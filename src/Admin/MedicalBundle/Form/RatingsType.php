<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RatingsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$services = (($options['data']->getServices() == '') ? 1 : $options['data']->getServices());
		$environment = (($options['data']->getEnvironment() == '') ? 1 : $options['data']->getEnvironment());
		$staff = (($options['data']->getStaff() == '') ? 1 : $options['data']->getStaff());
		
        $builder
            ->add('only_rating','checkbox',array('required'=>false))
            ->add('name','text',array('required'=>true))
            ->add('lastname','text',array('required'=>true))
            ->add('email','email',array('required'=>true))			
			->add('rating_date', 'date' ,array('widget' => 'single_text','required' => true, 'attr' => array('class'=>'date-picker')))            
            ->add('comments','textarea',array('required'=>true))
            ->add('services', 'choice', array('choices' => array('1'=>' ','2'=>' ','3'=>' ','4'=>' ','5'=>' ','6'=>' ','7'=>' ','8'=>' ','9'=>' ','10'=>' '),'data' => $services,'empty_value'=>false, 'expanded'=>true, 'multiple'=>false, 'required' => false))
            ->add('environment', 'choice', array('choices' => array('1'=>' ','2'=>' ','3'=>' ','4'=>' ','5'=>' ','6'=>' ','7'=>' ','8'=>' ','9'=>' ','10'=>' '),'data' => $environment,'empty_value'=>false,'expanded'=>true, 'multiple'=>false,'required'    => false, 'attr' => array('class'=>'star')))
            ->add('staff', 'choice', array('choices' => array('1'=>' ','2'=>' ','3'=>' ','4'=>' ','5'=>' ','6'=>' ','7'=>' ','8'=>' ','9'=>' ','10'=>' '),'data' => $staff,'empty_value'=>false,'expanded'=>true, 'multiple'=>false,'required'    => false, 'attr' => array('class'=>'star')))
			->add('countries', 'entity', array(
                    'class' => 'Admin\MedicalBundle\Entity\Country',
                    'query_builder' => function(EntityRepository $er)
                    {
                      return $er->createQueryBuilder('f')                             
                              ->orderBy('f.id', 'ASC');
                    },
					'empty_value' => 'Choose a country',
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => false					
                ));			
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\Ratings'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_ratings';
    }
}