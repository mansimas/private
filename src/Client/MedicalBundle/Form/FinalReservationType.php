<?php

namespace Client\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FinalReservationType extends AbstractType
{
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        if($routeName == "client_final_reservation") {
            $builder->add('resi_address_one', 'text', array('required'=>true,"mapped"=>false))
                ->add('resi_address_two', 'text', array('required'=>false,"mapped"=>false))
                ->add('resi_city', 'text', array('required'=>true,"mapped"=>false))
                ->add('resi_state', 'text', array('required'=>false, "mapped"=>false))
                ->add('resi_zip', 'text', array('required'=>false, "mapped"=>false))
                ->add('resi_country_id', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Country',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('f')->orderBy('f.id', 'ASC');
                    },
                    'empty_value' => 'Choose a country',
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => array('class' => "chosen-select",'data-placeholder'=>"select countries"),
                    'required' => true,
                    "mapped"=>false
                ));
        }
        if($routeName == "client_final_reservation" || $routeName == "client_twentyfour_reservation") {
            $builder->add('offers', 'choice', array('choices' => array(
                '1'=> 'All included assistance for your stay',
                '2'=> 'Pick up at the airport',
                '3'=>'Guided tours in Lithuania'
            ),'expanded'=>true, 'multiple'=>true, 'required' => false,"mapped"=>false))
            ->add('specific_wishes', 'textarea', array('required'=>false, 'label'=>'State',"mapped"=>false));
        }
        if($routeName != "client_twentyfour_reservation") {
            $builder
                ->add('firstname','text',array('required'=>true))
                ->add('middlename','text',array('required'=>false))
                ->add('lastname','text',array('required'=>true))
                ->add('email','email',array('required'=>true))
                ->add('phone','text',array('required'=>false))
                ->add('countries', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Country',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('f')->orderBy('f.id', 'ASC');
                    },
                    'empty_value' =>'Choose a country',
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => array('class' => "chosen-select",'data-placeholder'=>"select countries"),
                    'required' => true
                ));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array('data_class' => 'Admin\MedicalBundle\Entity\UserQuoteDetail'));
    }

    public function getName(){
        return 'client_medicalbundle_final_reservation';
    }
}