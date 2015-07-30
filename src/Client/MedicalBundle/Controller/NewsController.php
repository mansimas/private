<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asNewsData = $em->getRepository('AdminMedicalBundle:News')->getLatestNewsDetail($ssLocale);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->
        getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 10);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($asNewsData,$ssPage,$ssPerPage);
        $pagination->setUsedRoute('client_medical_news');
        $pagination->setCustomParameters(array('ssUpdateDiv' => 'news_div','ssPerPage'=>$ssPerPage));
        if($request->isXmlHttpRequest()) {
            if($request->get('specialoffer_type')=='simple') {
                $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->
                getSpecialOfferRandomDetail($ssLocale,'',true);
                return $this->render('ClientMedicalBundle:Company:specialoffers.html.twig',array(
                    'asSpecialOffersData'=>$asSpecialOffersData,
                    'ssRoute'=>'client_medical_news'
                ));
            } else {
                return $this->render('ClientMedicalBundle:News:newslisting.html.twig', array(
                    'pagination' => $pagination,
                    'ssRoute'=>'client_medical_news'
                ));
            }
        } else {
            return $this->render('ClientMedicalBundle:News:index.html.twig', array(
                'pagination'=>$pagination,
                'ssRoute'=>'client_medical_news',
                'asMetaData' => $asMetaData
            ));
        }
    }

    public function newsdetailAction(Request $request) {
        $snNewsId = $request->get('id');
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asNewsData = $em->getRepository('AdminMedicalBundle:News')->getAllNewsCategoryCompanywiseDetail($ssLocale, $snNewsId);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($request->isXmlHttpRequest()) {
            $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale,'',true);
            return $this->render('ClientMedicalBundle:Company:specialoffers.html.twig', array(
                'asSpecialOffersData'=>$asSpecialOffersData,
                'ssRoute'=>'client_medical_news_detail'
            ));
        } else {
            return $this->render('ClientMedicalBundle:News:newsdetail.html.twig', array(
                'asNewsData'=>$asNewsData,
                'locale'=>$locale,
                'ssRoute'=>'client_medical_news_detail',
                'asMetaData' => $asMetaData
            ));
        }
    }

    public function bannersAction($ssPage, $snCategoryId='', $lang = 'lt'){
        $em = $this->getDoctrine()->getManager();
        switch($ssPage) {
            case 'company_listing':
                $ssBannerType = 'home_right';
                $asBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getAddBannerDetail($ssBannerType, $snCategoryId, '', '', '', $lang);
                if(is_array($asBannerDetail) && empty($asBannerDetail) && $snCategoryId != '') {
                    $asBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getAddBannerDetail($ssBannerType, '', '', '', '', $lang);
                }
            break;
            case 'news':
                $ssBannerType = 'news_right';
                $asBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getNewsStaicBannersDetail($ssBannerType, $lang);
            break;
            case 'static_articles':
                $ssBannerType = '';
                $asBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getNewsStaicBannersDetail($ssBannerType, $lang);
            break;
        }
        return $this->render('ClientMedicalBundle:News:banners.html.twig', array('asBannerDetail'=>$asBannerDetail,'ssPage'=>$ssPage));
    }
}