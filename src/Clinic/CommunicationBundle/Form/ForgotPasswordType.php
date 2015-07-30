<?php

namespace Clinic\CommunicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForgotPasswordType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', 'text');
        $builder->add('Priminti', 'submit', array(
            'attr' => array('class' => 'btn btn-success'),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Clinic\CommunicationBundle\Form\Model\ForgotPassword',
        ));
    }

    public function getName() {
        return 'forgot_password';
    }

}
