<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\MedicalBundle\Entity\InsuranceRepository;
use Admin\MedicalBundle\Entity\Insurance;
use Admin\MedicalBundle\Entity\LanguagesRepository;
use Admin\MedicalBundle\Entity\Languages;
use Admin\MedicalBundle\Entity\Company;
use Symfony\Component\HttpFoundation\Session\Session;

class CompanyType extends AbstractType
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
		$locale = $this->container->get('session')->get('_locale');
		$ssLocale = ( (isset($locale) && $locale != '') ? $locale : 'en' );
		$em = $this->container->get('doctrine.orm.entity_manager');
		
		$asLanguageData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
		$asPaymentOptionData = $em->getRepository('AdminMedicalBundle:PaymentOption')->findAll();
		$asData = $em->getRepository('AdminMedicalBundle:Insurance')->getInsuranceTranslationDetail($ssLocale, true);
		
		$asCategoryDataInRecursive = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryDetail($ssLocale, 1);
		
		$asCategoryData = array();
		if($options['data']->getId() != '')
		{
			$asCategoryData = $em->getRepository('AdminMedicalBundle:Company')->getDataByCompanyId($ssLocale, $options['data']->getId());		
		}
		
        $builder
			->add('categories','choice', array('mapped'=>false, 'choices'   => 
												$asCategoryDataInRecursive,
												'expanded' => false,
												'multiple' => true,
												'data' => array_keys($asCategoryData),
												'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add category")))
			->add('doctors', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Doctor',
                    'query_builder' => function(EntityRepository $er)
                    {
                      return $er->createQueryBuilder('c')                              
                              ->orderBy('c.id', 'DESC');
                    },
                    'property' => 'firstname',
                    'expanded' => false,
                    'multiple' => true,
					'required' => false,
					'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add doctors")
                ))
			
            ->add('name')
            ->add('company_code')            
            ->add('vat_code')
            ->add('licence_number')
            ->add('address', 'text', array('attr'=>array('onBlur'=>'getAddressMapInitialize()')))
            ->add('city')
            ->add('zip','text')
			->add('fixed_fee','text',array('required'=>true))
            ->add('fixed_fee_percentage','text',array('required'=>true))
			->add('countries','entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Country',
                    'query_builder' => function(EntityRepository $er)
                    {
                      return $er->createQueryBuilder('f')                             
                              ->orderBy('f.id', 'ASC');
                    },
					'empty_value' => 'Choose a country',
                    'property' => 'name',					
                ))
				
            ->add('disable_quotes')
            ->add('primary_phone','text')
            ->add('cell_phone','text')
            ->add('fax','text',array('required'=>false))
            ->add('email','email')
            ->add('username')
			->add('password','password',array('required'=>false))
            ->add('company_note','textarea',array('required'=>false,'attr' => array("col" =>10, "row" => 1)))
            ->add('badges', 'choice', array('choices' => array('M' => 'Member of association', 'C' => 'Certified', 'I' => 'International partnership'), 'expanded'=>true,'multiple'=>true))
            ->add('translations', 'a2lix_translations_gedmo', array(
                'locales' => array('en','lt','ru','de'),
                'required' => false,
                'label'=>'Translations',
                'fields'=>array(
                    'keyword'=>array('field_type'=>'text',
                        'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                            'en' => array(
                                'label' => 'Meta keyword'        // [optional] Higher priority
                            ),
                        )),
                    'description'=>array('field_type'=>'textarea',
                        'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                            'en' => array(
                                'label' => 'Meta description'        // [optional] Higher priority
                            ),
                        )),
                    'badge_text_M'=>array('field_type'=>'textarea',
                        'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                            'en' => array(
                                'label' => 'Badge text - Member of Association'        // [optional] Higher priority
                            ),
                        )),
                    'badge_text_C'=>array('field_type'=>'textarea',
                        'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                            'en' => array(
                                'label' => 'Badge text - Certified'        // [optional] Higher priority
                            ),
                        )),
                    'badge_text_I'=>array('field_type'=>'textarea',
                        'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                            'en' => array(
                                'label' => 'Badge text - International'        // [optional] Higher priority
                            ),
                        )),
                    'badge_text_H'=>array('field_type'=>'textarea',
                        'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                            'en' => array(
                                'label' => 'Badge text - Health insurance'        // [optional] Higher priority
                            ),
                        )),

                )))
			->add('languagess', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Languages',                    
					'choices' => $asLanguageData,
                    'property' =>  'name',
                    'expanded' => true,
                    'multiple' => true
                ))
			
			->add('paymentoptions', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\PaymentOption',                    
					'choices' => $asPaymentOptionData,
                    'property' =>  'title',
                    'expanded' => true,
                    'multiple' => true
                ))			
			->add('insurances', 'entity', array(
					'required'=>false,
                    'class' => 'Admin\MedicalBundle\Entity\Insurance',                    
					'choices' => $asData,
                    'property' =>  'name',
                    'expanded' => false,
                    'multiple' => true,
					'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add insurance company")
                ))

			->add('premium_company')
			->add('final_price_info')
			->add('small_company');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\Company'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_company';
    }
}