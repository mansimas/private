<?php

namespace Client\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InsuranceType extends AbstractType
{
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $locale = $this->container->get('session')->get('_locale');
        $ssLocale = ( (isset($locale) && $locale != '') ? $locale : 'en' );
        $em = $this->container->get('doctrine.orm.entity_manager');
        $asData = $em->getRepository('AdminMedicalBundle:Insurance')->getInsuranceTranslationDetail($ssLocale);
        $builder
            ->add('insurances', 'entity', array(
                'class' => 'Admin\MedicalBundle\Entity\Insurance',
                'choices' => $asData,
                'property' =>  'name',
                'expanded' => false,
                'multiple' => true,
                'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add insurance company")
            ))
            ->add('countries', 'entity', array(
                'class' => 'Admin\MedicalBundle\Entity\Country',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.id', 'ASC');
                },
                'empty_value' => 'Choose a country',
                'property' => 'name',
                'expanded' => false,
                'multiple' => false,
                'attr' => array(
                    'class' => "chosen-select",
                    'data-placeholder'=>"select countries",
                    'onChange'=>'getInsurance(this.value);'
                )
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array('data_class' => 'Admin\MedicalBundle\Entity\Insurance'));
    }

    public function getName(){
        return 'admin_medicalbundle_insurance';
    }
}