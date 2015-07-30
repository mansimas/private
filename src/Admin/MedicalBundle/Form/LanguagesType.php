<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LanguagesType extends AbstractType
{
    private $entityManager;
  
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$value = $options['data']->getFlag() == '' ? 'true' : 'false';
		$value = (($options['data']->getFlag() == '') ? true : false);
        $builder
			->add('name', 'text')
			->add('code', 'text')
			->add('flag', 'file',array('required' => $value,'data_class' => null));
    }
 
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\Languages'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_languages';
    }
}