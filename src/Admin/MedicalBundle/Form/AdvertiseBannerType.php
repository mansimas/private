<?php

namespace Admin\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AdvertiseBannerType extends AbstractType
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
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$value = (($options['data']->getPhoto() == '') ? true : false);
        $locale = $this->container->get('session')->get('_locale');
		
		$ssLocale = ( (isset($locale) && $locale != '') ? $locale : 'en' );
		
		$em = $this->container->get('doctrine.orm.entity_manager');
		
		$asCategoryDataInRecursive = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryDetail($ssLocale, 1);
		
		$asCategoryData = array();
		if($options['data']->getId() != '')
		{
			$asCategoryData = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getDataByBannerId($ssLocale, $options['data']->getId());		
		}
        $builder
			->add('categories','choice', array('required' => false,'mapped'=>false, 'choices'   => 
												$asCategoryDataInRecursive,
												'expanded' => false,
												'multiple' => true,
												'data' => array_keys($asCategoryData),
												'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add category")))         
            ->add('photo', 'file',array('required' => false,'data_class' => null))
			->add('client','text',array('required'=>true))
			->add('notes','textarea',array('required'=>false))
			->add('status', 'choice', array('choices' => array('active' => 'Active', 'stop' => 'Stopped'),'data' => 'active','expanded'  => true,'multiple'  => false))
            ->add('lang','choice',array('choices'   => array(''=>'--Select--','lt' => 'Lithuanian','en' => 'English','ru'=>'Russian', 'de'=>'German')))

            ->add('name','textarea',array('required'=>true))
			->add('position','choice',array('choices'   => array(''=>'--Select--','home_right' => 'Home right','news_right' => 'News right','company_center'=>'Company center')))
			->add('start_date', 'date' ,array('widget' => 'single_text','required' => false, 'attr' => array('class'=>'date-picker')))			
			->add('end_date', 'date' ,array('widget' => 'single_text','required' => false, 'attr' => array('class'=>'date-picker')))			
			->add('total_shows','text',array('required'=>false))
			->add('photo_height','text',array('required'=>false))
			->add('photo_width','text',array('required'=>false))
			->add('url','url',array('required'=>false))
			->add('flash_file','textarea',array('required'=>false))
			->add('script_detail','textarea',array('required'=>false))
			->add('new_window','checkbox',array('required'=>false))
			->add('cities', 'entity', array('required' => false,
                    'class' => 'Admin\MedicalBundle\Entity\City',
                    'query_builder' => function(EntityRepository $er)
                    {
                      return $er->createQueryBuilder('f')
                              //->leftJoin('f.category', 'c')
                              //->andWhere('c.code = :codeCat')
                              //->setParameter('codeCat', $this->codeCat)
                              ->orderBy('f.id', 'ASC');
                    },
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => true,
					'attr' => array('class' => "chosen-select",'data-placeholder'=>"Add cities")
                ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MedicalBundle\Entity\AdvertiseBanner'
        ));        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_medicalbundle_advertise_banner';
    }
}
