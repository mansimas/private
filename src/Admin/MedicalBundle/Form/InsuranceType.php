<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InsuranceType extends AbstractType
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
  
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$value = (($options['data']->getPhoto() == '') ? true : false);
		
		$em = $this->container->get('doctrine.orm.entity_manager');		
		$asLanguageData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
		if(is_array($asLanguageData) && !empty($asLanguageData))
		{
			foreach($asLanguageData as $snKey=>$asVal)
				$asLanguageCode[] = $asVal->getCode();
		}
		else
			$asLanguageCode = $this->container->getParameter('default_locales');
		
        $builder
			->add('photo', 'file',array('required' => $value,'data_class' => null))
            ->add('translations', 'a2lix_translations_gedmo', array(
			    'locales' => $asLanguageCode,
				'required' => false,                      
                'label'=>'Translations',                
                'fields'=>array( 
                    'name'=>array('field_type'=>'text',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Name'        // [optional] Higher priority                        
                    ),                   
                )),
                    'url'=>array('field_type'=>'text',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Url'        // [optional] Higher priority                        
                    ),                   
                )),
                    'description'=>array('field_type'=>'ckeditor',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Description'        // [optional] Higher priority                        
                    ),                   
                )),
                    
            )))
            ->add('countries', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Country',
                    'query_builder' => function(EntityRepository $er)
                    {
                      return $er->createQueryBuilder('f')
                              //->leftJoin('f.category', 'c')
                              //->andWhere('c.code = :codeCat')
                              //->setParameter('codeCat', $this->codeCat)
                              ->orderBy('f.id', 'ASC');
                    },
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => true,
					'attr' => array('class' => "chosen-select",'data-placeholder'=>"select countries")
                ));  
    }
 
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\Insurance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_insurance';
    }
}