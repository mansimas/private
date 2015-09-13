<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryPriceType extends AbstractType
{

    private $container;

    /**
     *
     * @param type $container
     */
    public function __construct($container)
    {
        $this->container = $container;

    }


    public function buildForm(FormBuilderInterface $builder, array $options){
        $locale = $this->container->get('session')->get('_locale');
        $ssLocale = ( (isset($locale) && $locale != '') ? $locale : 'en' );
        $em = $this->container->get('doctrine.orm.entity_manager');
        $asCategoryDataInRecursive = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryDetail($ssLocale, 1);

        $builder
            ->add('categories','collection', array(
                'type' => 'choice',
                'allow_add'=>true,
                'allow_delete' => true,
                'options'=>array(
                    'required'=>false,
                    'choices' => $asCategoryDataInRecursive,
                    'attr'=>array('style' => 'max-width: 150px', 'class'=>'company_price_category'))
            ))
            ->add('minprice','collection', array(
                'type' => 'text',
                'allow_add'=>true,
                'allow_delete' => true,
                'options'=>array(
                    'required'=>false,
                    'attr'=>array('style' => 'width: 40px', 'class'=>'company_price_price'))
            ))
            ->add('maxprice','collection', array(
                'type' => 'text',
                'allow_add'=>true,
                'allow_delete' => true,
                'options'=>array(
                    'required'=>false,
                    'attr'=>array('style' => 'width: 40px', 'class'=>'company_price_price'))
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array('data_class' => 'Admin\MedicalBundle\Entity\CompanyCategory'));
    }

    public function getName(){
        return 'client_medicalbundle_category_price';
    }
}
