<?php

namespace Client\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteType extends AbstractType
{
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $locale = $this->container->get('session')->get('_locale');
        $ssLocale = ( (isset($locale) && $locale != '') ? $locale : 'en' );
        $em = $this->container->get('doctrine.orm.entity_manager');
        $asCategoryData = $em->getRepository('AdminMedicalBundle:Category')->
        getAllTranslationCategoryDetailObject($ssLocale,true);
        $builder
            ->add('firstname','text',array('required'=>false))
            ->add('middlename','text',array('required'=>false))
            ->add('lastname','text',array('required'=>false))
            ->add('email','email',array('required'=>false))
            ->add('phone','text',array('required'=>true))
            ->add('countries', 'entity', array(
                'class' => 'Admin\MedicalBundle\Entity\Country',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')->orderBy('f.id', 'ASC');
                    },
                    'empty_value' =>'Choose a country',
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => array('data-placeholder'=>"select countries"),
                    'required' => false
                ))
            ->add('unique_id','hidden',array('required'=>false))
            ->add('quote_status','choice',array('choices'   => array(
                'unverified' => 'Unverified',
                'active' => 'Active',
                'archive'   => 'Archive',
                'blocked'   => 'Blocked',
                'Completed' => 'Completed')
            ))
            ->add('prefferd_language','choice', array('choices' => array(
                'E'=>'English',
                'R'=> 'Russian',
                'D'=>'Deutch',
                'L'=>'Lithuania'
            ),'data' => 'E','empty_value'=>false, 'expanded'=>true, 'multiple'=>false, 'required' => false))
            ->add('categories', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Category',
                    'choices' => $asCategoryData,
                    'property' =>  'name',
                    'expanded' => true,
                    'multiple' => true,
                    'empty_value' => 'Choose a category',
                    'required'=>false
               ))
            ->add('companies', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Company',
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('c')->orderBy('c.id', 'DESC');
                    },
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => true,
                    'mapped' => false,
                    'required' => false,
                    'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add companies")
                ))
            ->add('urgent_medical_service','choice', array('choices' => array(
                'N'=> 'No' ,
                'Y'=> 'Yes, I need medical services ASAP'
            ),'data' => 'N','empty_value'=>false, 'expanded'=>true, 'multiple'=>false, 'required' => false))
            ->add('health_problem','textarea',array('required'=>false))
            ->add('read_terms_condition', 'checkbox', array('required'=>true));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array('data_class' => 'Admin\MedicalBundle\Entity\UserQuoteDetail'));
    }

    public function getName(){
        return 'client_medicalbundle_user_quote_detail';
    }
}