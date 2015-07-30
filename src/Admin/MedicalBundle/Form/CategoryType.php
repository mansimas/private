<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Admin\MedicalBundle\Entity\Category;
use Admin\MedicalBundle\Entity\Categorytranslation;


class CategoryType extends AbstractType
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
		$value = (($options['data']->getPhoto() == '') ? true : false);
		$locale = $this->container->get('session')->get('_locale');
		$ssLocale = ( (isset($locale) && $locale != '') ? $locale : 'en' );
		//echo $ssLocale; exit;
		$em = $this->container->get('doctrine.orm.entity_manager');
		$mncatData = $em->getRepository('AdminMedicalBundle:Category')->getMainCategory($ssLocale, 1);
		
		/* put dynamic language translation editor if no language add then get default_locales */		
		$asLanguageData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
		if(is_array($asLanguageData) && !empty($asLanguageData))
		{
			foreach($asLanguageData as $snKey=>$asVal)
				$asLanguageCode[] = $asVal->getCode();	
		}
		else
			$asLanguageCode = $this->container->getParameter('default_locales');
	    /* put dynamic language translation editor if no language add then get default_locales */
		
        $builder
            ->add('category', 'entity', array(
                    'label' => 'Category',
                    'empty_value' => '-- Choose a Category --',
                    'mapped' => false,  
                    'class' => 'Admin\MedicalBundle\Entity\Category',
                    'property' => 'name',
					'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'choices' => $mncatData
                ))    
			
            ->add('sub_category', 'choice', array(
                'label' => 'Sub category',
                'empty_value'   => '-- Choose a Sub category --',
                'mapped' => false,
				'required' => false,
             ))
                            
            ->add('sub_sub_category', 'choice', array(
                'label' => 'Sub-Sub category',
                'empty_value'   => '-- Choose a Sub - Sub category --',
                'mapped' => false,
				'required' => false,
            ))
			->add('photo', 'file',array('required' => $value,'data_class' => null))
            //->add('name')
			->add('translations', 'a2lix_translations_gedmo', array(
                'locales' => $asLanguageCode,
				'required' => false,                
                'label'=>'Translations',                
                'fields'=>array( 
                    'name'=>array('field_type'=>'text',
                        'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
						'en' => array(
                        'label' => 'Category'        // [optional] Higher priority                        
                    ),                   
					)),
				'url'=>array('field_type'=>'text',
                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                    'label' => 'URL'        // [optional] Higher priority                        
                    ),                   
                )),
				'metadescription'=>array('field_type'=>'textarea',
					'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
					'en' => array(
					'label' => 'Meta Description'        // [optional] Higher priority
					),
				)),
				'description'=>array('field_type'=>'ckeditor',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Description'        // [optional] Higher priority                        
                    ),                   
                )),
            )))
        ;
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\Category',
            
        ));
        
       
    }
    
   /* public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'cateogy_code';
    }*/
  
    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_category';
    }
}
