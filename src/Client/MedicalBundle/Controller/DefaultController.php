<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {
        set_time_limit(6000);
        ini_set("memory_limit", -1);
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asLanguageData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
        $asPaymentOptionData = $em->getRepository('AdminMedicalBundle:PaymentOption')->findAll();
        $asCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllCategoryDetail($ssLocale, true);
        $asCompanyCityData = $em->getRepository('AdminMedicalBundle:City')->findAll();
        $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale,'',true,'latest');
        $asRatingsData = $em->getRepository('AdminMedicalBundle:Ratings')->getLatestRatingsDetail();
        $asVideodata = $em->getRepository('AdminMedicalBundle:Video')->getAllVideoDetail($ssLocale);
        $asNewsData = $em->getRepository('AdminMedicalBundle:News')->getLatestNewsDetail($ssLocale, true);
        $asRandomTestimonialData = $em->getRepository('AdminMedicalBundle:Testimonial')->getLatestTestimonial($ssLocale);

        return $this->render('ClientMedicalBundle:Default:index.html.twig',
            array('asCategoryData' => $asCategoryData,
                'asCompanyCityData'=>$asCompanyCityData,
                'asSpecialOffersData'=>$asSpecialOffersData,
                'asRatingsData'=>$asRatingsData,
                'asNewsData'=>$asNewsData,
                'asLanguageData'=>$asLanguageData,
                'asPaymentOptionData'=>$asPaymentOptionData,
                'asVideodata'=>$asVideodata,
                'asRandomTestimonialData'=>$asRandomTestimonialData,
                'asMetaData'=>$asMetaData
            ));
    }

    public function placestovisitAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('PLACE_TO_VISIT', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function consultantionAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('CONSULTANTION_FEE', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function insurancefundAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('EXPENSE_INSURANCE_FUND', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function visatravelsAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('VISA_TRAVELS', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function aboutmedicalAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('ABOUT_MEDICAL', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function casedisputeAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('CASE_OF_DISPUTE', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig',array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function testimonialAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asTestimonialData = $em->getRepository('AdminMedicalBundle:Testimonial')->getAllTestimonialVideoDetail();

        return $this->render('ClientMedicalBundle:Default:testimonial.html.twig', array('asTestimonialData'=>$asTestimonialData,'asMetaData'=>$asMetaData));
    }

    public function categoriesAction($ssRoute) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asData = $em->getRepository('AdminMedicalBundle:Category')->getAllCategoryDetail($ssLocale, true,'','Active');
        return $this->render('ClientMedicalBundle:Default:categories.html.twig', array('asData'=>$asData,'ssRoute'=>$ssRoute));
    }

    public function showmapAction(Request $request) {
        $ssAddress = $request->get('address');
        $ssCompanyName = $request->get('company_name');
        return $this->render('ClientMedicalBundle:Default:showmap.html.twig', array('ssAddress'=>$ssAddress,'ssCompanyName'=>$ssCompanyName));
    }

    public function fetchAction(Request $request) {
        $cat_id = $request->get('categorie_id');
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asSubCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategory($ssLocale,$cat_id);
        $arr2=array();
        $arr=array();
        foreach($asSubCategoryData as $r) {
            $arr['id']=$r['id'];
            $arr['name']= $r['name'];
            $arr2[]=$arr;
        }
        if(count($arr2) > 0 && $arr['name'] != '') {
            echo json_encode($arr2);
        } else {
            echo '';
        }
        exit;
    }

    public function termsofuseAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('TERMS_OF_USE', $ssLocale);
        if($request->get('popup') == 1) {
            return $this->render('ClientMedicalBundle:Default:termsofuse.html.twig', array('asData'=>$asData));
        } else {
            return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
        }
    }

    public function allreviewsAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asRatingsData = $em->getRepository('AdminMedicalBundle:Ratings')->getLatestRatingsDetail(true);
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 10);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($asRatingsData,$ssPage,$ssPerPage);
        $pagination->setUsedRoute('client_medical_allreviews');
        $pagination->setCustomParameters(array('ssUpdateDiv' => 'news_div','ssPerPage'=>$ssPerPage));
        if($request->isXmlHttpRequest()) {
            if($request->get('specialoffer_type')=='simple') {
                $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale,'',true);
                return $this->render('ClientMedicalBundle:Company:specialoffers.html.twig',array(
                    'asSpecialOffersData'=>$asSpecialOffersData,
                    'ssRoute'=>'client_medical_allreviews'
                ));
            } else {
                return $this->render('ClientMedicalBundle:Default:allreviewslisting.html.twig', array(
                    'pagination' => $pagination,
                    'ssRoute'=>'client_medical_allreviews'
                ));
            }
        } else {
            return $this->render('ClientMedicalBundle:Default:allreviews.html.twig', array(
                'pagination'=>$pagination,
                'ssRoute'=>'client_medical_allreviews',
                'asMetaData'=>$asMetaData
            ));
        }
    }

    public function guarantiesAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('GUARANTIES', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function forclinicsAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('FOR_CLINICS', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function foragenciesAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('FOR_AGENCIES', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }

    public function contactsAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('CONTACTS', $ssLocale);

        return $this->render('ClientMedicalBundle:Default:cmsstaticarticle.html.twig', array('asData'=>$asData,'asMetaData'=>$asMetaData));
    }
}