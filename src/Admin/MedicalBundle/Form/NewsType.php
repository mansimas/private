<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;
use Admin\MedicalBundle\Entity\Company;

class NewsType extends AbstractType
{
	private $container;

	/**
	*
	* @param type $container
	*/
	public function __construct($container)
	{
		$this->container = $container;
		
	}
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		/* put dynamic language translation editor if no language add then get default_locales */
		$em = $this->container->get('doctrine.orm.entity_manager');		
		$asLanguageData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
		if(is_array($asLanguageData) && !empty($asLanguageData))
		{
			foreach($asLanguageData as $snKey=>$asVal)
				$asLanguageCode[] = $asVal->getCode();
		}
		else
			$asLanguageCode = $this->container->getParameter('default_locales');
	    /* put dynamic language translation editor if no language add then get default_locales */

		$value = (($options['data']->getPhoto() == '') ? true : false);
		
		$builder
		    ->add('status','choice',array('choices'   => array('Published' => 'Published','Unpublished' => 'Unpublished')))
			->add('news_date', 'date' ,array('widget' => 'single_text','required' => false, 'attr' => array('class'=>'date-picker')))			
            ->add('photo', 'file',array('required' => $value,'data_class' => null))			
            ->add('translations', 'a2lix_translations_gedmo', array(
                'locales' => $asLanguageCode,
				'required' => false,              
                'label'=>'Translations',                
                'fields'=>array( 
                    'title'=>array('field_type'=>'text',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Title'        // [optional] Higher priority                        
                    ),                   
                )),
				'url'=>array('field_type'=>'text',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'URL'        // [optional] Higher priority                        
                    ),                   
                )),
                    'description'=>array('field_type'=>'ckeditor',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Description'        // [optional] Higher priority                        
                    ),                   
                )),
                    
            )))
			->add('company', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Company',
                    'query_builder' => function(EntityRepository $er)
                    {
                      return $er->createQueryBuilder('c')                              
                              ->orderBy('c.id', 'DESC');
                    },
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => true,
					'required' => false,
					'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add companies")
                ))
			->add('categories', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Category',
                    'query_builder' => function(EntityRepository $er)
                    {
                      return $er->createQueryBuilder('c')                              
                              ->orderBy('c.id', 'DESC');
                    },
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => true,
					'required' => false,
					'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add categories")
                ));			
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\News'
        ));        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_news';
    }
}
