<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Admin\MedicalBundle\Entity\Category;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $locale = $this->get('session')->get('_locale');        
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');        
        $em = $this->getDoctrine()->getManager();
        $asCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllCategoryInBlock($ssLocale);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        return $this->render('ClientMedicalBundle:Category:index.html.twig',array('asCategoryData' => $asCategoryData,'asMetaData' => $asMetaData));
    }

    public function categorydetailAction(Request $request)
    {
        $snCategoryId = $request->get('id');
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllCategoryDetail($ssLocale,'',$snCategoryId);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asCompanyByCategoryData = $em->getRepository('AdminMedicalBundle:Company')->getCompanyByCategoyId($ssLocale, $snCategoryId);
        if($request->isXmlHttpRequest()) {
            $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale,'',true);
            return $this->render('ClientMedicalBundle:Company:specialoffers.html.twig', array('asSpecialOffersData'=>$asSpecialOffersData,'ssRoute'=>'client_medical_news_detail'));
        } else {
            return $this->render('ClientMedicalBundle:Category:categorydetail.html.twig', array(
                'asCategoryData'=>$asCategoryData,
                'asCompanyByCategoryData'=>$asCompanyByCategoryData,
                'ssRoute'=>'client_medical_category_detail',
                'asMetaData' => $asMetaData
            ));
        }
    }

}