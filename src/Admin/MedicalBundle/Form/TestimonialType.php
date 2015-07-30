<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TestimonialType extends AbstractType
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
		$builder		    		
            ->add('translations', 'a2lix_translations_gedmo', array(
                'locales' => $asLanguageCode,
				'required' => false,             
                'label'=>'Translations',                
                'fields'=>array(                      
					'url'=>array('field_type'=>'url',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority                                     
                )),				
            )));
			
		
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\Testimonial'
        ));        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_testimonial';
    }
}
