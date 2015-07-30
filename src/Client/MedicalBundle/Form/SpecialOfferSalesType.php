<?php

namespace Client\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecialOfferSalesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('name','text',array('required'=>true))
            ->add('email','email',array('required'=>true))
            ->add('phone','text',array('required'=>true))
            ->add('number_of_coupon','text',array('required'=>false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array('data_class' => 'Admin\MedicalBundle\Entity\SpecialofferSales'));
    }

    public function getName(){
        return 'client_medicalbundle_specialoffer_sales';
    }
}