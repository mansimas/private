<?php

namespace Clinic\CommunicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClinicReplyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder			
			->add('reply_message_content','textarea',array('required'=>true))
			->add('service_description','text',array('required'=>false))
			->add('brief_service_description','textarea',array('required'=>false))
			->add('responsible_person_doctor','text',array('required'=>false))
			->add('reservation_date', 'date' ,array('widget' => 'single_text','required' => false, 'attr' => array('class'=>'date-picker')))			
			->add('reservation_time', 'time' ,array('widget' => 'single_text','required' => false, 'with_minutes'=>true,'with_seconds'=>false,'attr' => array('class'=>'input-small')))
			->add('service_price','text',array('required'=>true))
			->add('offer_end_date', 'date' ,array('widget' => 'single_text','required' => false, 'attr' => array('class'=>'date-picker')));			
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\UserCompanyCommunication'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'clinic_communicationbundle_user_company_communication';
    }
}