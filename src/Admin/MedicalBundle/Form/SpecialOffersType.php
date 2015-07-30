<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecialOffersType extends AbstractType
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
			->add('photo', 'file',array('required' =>$value,'data_class' => null))
            ->add('status','choice',array('choices'   => array('active' => 'Active','stopped' => 'Stopped','expire'   => 'Expire')))            
            ->add('start_date', 'date' ,array('widget' => 'single_text','required' => false, 'attr' => array('class'=>'date-picker')))
			->add('start_time', 'time' ,array('widget' => 'single_text','required' => false, 'with_minutes'=>true,'with_seconds'=>true, 'attr' => array('class'=>'input-small')))
            ->add('end_date', 'date' ,array('widget' => 'single_text','required' => false,'attr' => array('class'=>'date-picker')))
			->add('end_time', 'time' ,array('widget' => 'single_text','required' => false, 'with_minutes'=>true,'with_seconds'=>true,'attr' => array('class'=>'input-small')))				
			->add('responsible_person','text',array('required'=>true))
			->add('coupon_valid_date', 'date' ,array('widget' => 'single_text','required' => false, 'attr' => array('class'=>'date-picker')))
			->add('regular_price','text',array('required'=>true))
            ->add('sales_price','text',array('required'=>true))
            ->add('contract_num','text',array('required'=>true))
            ->add('client_fee','text',array('required'=>false))
            ->add('client_fee_percentage','text',array('required'=>false))
			//->add('unique_id','hidden',array('required'=>false))
            ->add('other_info','textarea',array('required'=>false))
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
                    'introduction'=>array('field_type'=>'textarea',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Introduction'        // [optional] Higher priority                        
                    ),                   
                )),
                    'description'=>array('field_type'=>'ckeditor',
                                    'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                    'en' => array(
                        'label' => 'Main text'        // [optional] Higher priority                        
                    ),                   
                )),
                    
            )));            
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\SpecialOffers'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_specialoffers';
    }
}