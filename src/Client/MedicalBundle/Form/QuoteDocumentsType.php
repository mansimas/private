<?php

namespace Client\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteDocumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('documents','collection', array('type' => 'file','allow_add'=>true,'options'=>array('required'=>false)))
            ->add('description','collection', array(
                'type' => 'text',
                'allow_add'=>true,
                'options'=>array('required'=>false,'attr'=>array('class'=>'form-control input-sm'))
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array('data_class' => 'Admin\MedicalBundle\Entity\UserQuoteDocuments'));
    }

    public function getName(){
        return 'client_medicalbundle_user_quote_documents';
    }
}