<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommunicationMessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder			
			->add('reply_message_content','textarea',array('required'=>true));			
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