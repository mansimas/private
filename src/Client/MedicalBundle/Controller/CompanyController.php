<?php

namespace Client\MedicalBundle\Controller;

use Client\MedicalBundle\Services\Company\NameEditor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Client\MedicalBundle\Form\InsuranceType;
use Client\MedicalBundle\Form\QuoteType;
use Client\MedicalBundle\Form\QuoteDocumentsType;

use Admin\MedicalBundle\Entity\UserQuoteDetail;
use Admin\MedicalBundle\Entity\UserQuoteDocuments;
use Admin\MedicalBundle\Entity\UserCompanyQuotes;
use Admin\MedicalBundle\Entity\UserCompanyCommunication;

class CompanyController extends Controller
{
    public function indexAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $ssSerachParam = (($request->get('ssSearchParam') != '') ? $request->get('ssSearchParam') : '');
        $snNewsCategoryIds = (($request->get('news_category_ids') != '') ? $request->get('news_category_ids') : '');
        if(isset($request->get['category_ids_index']) && $request->get['category_ids_index'] != '') {
            $snCategoryIds = $request->get['category_ids_index'];
            if(isset($_POST['sub_category']) && $request->get['sub_category'] != '' && is_numeric($request->get['sub_category'])) {
                $snCategoryIds = $request->get['sub_category'];
            }
        } else if ($request->get('category_ids') != '') {
            $snCategoryIds = $request->get('category_ids');
        } else {
            $snCategoryIds = '';
        }
        $ssCityName = (($request->get('city_name') != '') ? $request->get('city_name') : '');
        $ssLanguages = $request->get('language');
        if(is_array($ssLanguages) && !empty($ssLanguages)) {
            $ssLanguages = implode(',',$ssLanguages);
        } else {
            $ssLanguages = (($request->get('language') != '') ? $request->get('language') : '');
        }
        $ssPaymentOption = $request->get('paymentoption');
        if(is_array($ssPaymentOption) && !empty($ssPaymentOption)) {
            $ssPaymentOption = implode(',',$ssPaymentOption);
        } else {
            $ssPaymentOption = (($request->get('paymentoption') != '') ? $request->get('paymentoption') : '');
        }
        $ssInsuranceIds = (($request->get('insurace_ids') != '') ? $request->get('insurace_ids') : '');
        $ssRatingPopular = (($request->get('rate_popular') != '') ? $request->get('rate_popular') : 'best');
        $ssRatingSlider = (($request->get('rateslider') != '') ? $request->get('rateslider') : '');
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 20);
        $ssClinicRating = (($request->get('clinic_rate') != '') ? $request->get('clinic_rate') : '');
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest() && $request->get('banner') != '') {
            $ssFlag = (($request->get('ssFlag') != '') ? $request->get('ssFlag') : '');
            $asBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getAddBannerDetail('home_right', $snCategoryIds, $ssFlag, $ssCityName, '', $locale);
            return $this->render('ClientMedicalBundle:News:banners.html.twig', array('asBannerDetail'=>$asBannerDetail, 'ssPage' => 'company_listing'));
        }

        $asCategoryDataInRecursive = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryDetail($ssLocale, 1);
        $arrayOfCategories = [];
        foreach($asCategoryDataInRecursive as $key=>$val) {
            $replaced = str_replace(["-", "--"], "", $val);
            $arrayOfCategories[] = $replaced;
        }
        $allCategories = json_encode(array_values($arrayOfCategories));


        $asMiddleBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getAddBannerDetail('company_center', $snCategoryIds, '' , $ssCityName, 'mid', $locale);
        $asCompanyData = $em->getRepository('AdminMedicalBundle:Company')->getCompanyAllDetail($ssSerachParam, $snCategoryIds, $ssCityName, $ssLanguages, $ssPaymentOption, $ssInsuranceIds, $ssLocale, $ssRatingPopular,$ssRatingSlider, $ssClinicRating);
        $snCount = ((count($asCompanyData) < 10) ? (count($asCompanyData) / 2) : ($ssPerPage / 2));
        array_splice($asCompanyData, $snCount, 0, $asMiddleBannerDetail);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($asCompanyData,$ssPage,$ssPerPage);
        $ssUpdateDiv = 'company_listing_div';
        $pagination->setCustomParameters(array('ssUpdateDiv' => $ssUpdateDiv,'ssPerPage' => $ssPerPage));
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($request->isXmlHttpRequest()) {
            return $this->render('ClientMedicalBundle:Company:companylistingnew.html.twig', array(
                'ssRatingPopular'=>$ssRatingPopular,
                'locale' => $ssLocale,
                'ssPage' => $ssPage,
                'ssUpdateDiv'=>$ssUpdateDiv,
                'pagination' => $pagination,
                'snCategoryIds'=>$snCategoryIds,
                'allCategories' => $allCategories,
                'ssCityName'=>$ssCityName,
                'ssPerPage'=>$ssPerPage)
            );
        } else {
            return $this->render('ClientMedicalBundle:Company:index2.html.twig', array(
                'ssPaymentOption'=>$ssPaymentOption,
                'ssClinicRating'=>$ssClinicRating,
                'ssCityName'=>$ssCityName,
                'ssLanguages'=>$ssLanguages,
                'ssRatingPopular'=>$ssRatingPopular,
                'locale' => $ssLocale,
                'pagination' => $pagination,
                'ssPage' => $ssPage,
                'ssSerachParam' => $ssSerachParam,
                'ssUpdateDiv'=>$ssUpdateDiv,
                'snCategoryIds'=>$snCategoryIds,
                'snNewsCategoryIds'=>$snNewsCategoryIds,
                'ssPerPage'=>$ssPerPage,
                'allCategories' => $allCategories,
                'asMetaData'=>$asMetaData
            ));
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function companysearchAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $ssSerachParam = (($request->get('ssSearchParam') != '') ? $request->get('ssSearchParam') : '');
        $snNewsCategoryIds = (($request->get('news_category_ids') != '') ? $request->get('news_category_ids') : '');
        if(isset($request->get['category_ids_index']) && $request->get['category_ids_index'] != '') {
            $snCategoryIds = $request->get['category_ids_index'];
            if(isset($_POST['sub_category']) && $request->get['sub_category'] != '' && is_numeric($request->get['sub_category'])) {
                $snCategoryIds = $request->get['sub_category'];
            }
        } else if($request->get('category_ids') != '') {
            $snCategoryIds = $request->get('category_ids');
        } else {
            $snCategoryIds = '';
        }
        $ssCityName = (($request->get('city_name') != '') ? $request->get('city_name') : '');
        $ssLanguages = $request->get('language');
        if(is_array($ssLanguages) && !empty($ssLanguages)) {
            $ssLanguages = implode(',',$ssLanguages);
        } else {
            $ssLanguages = (($request->get('language') != '') ? $request->get('language') : '');
        }
        $ssPaymentOption = $request->get('paymentoption');
        if(is_array($ssPaymentOption) && !empty($ssPaymentOption)) {
            $ssPaymentOption = implode(',',$ssPaymentOption);
        } else {
            $ssPaymentOption = (($request->get('paymentoption') != '') ? $request->get('paymentoption') : '');
        }
        $ssRatingPopular = (($request->get('rate_popular') != '') ? $request->get('rate_popular') : 'best');
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 20);
        $ssClinicRating = (($request->get('clinic_rate') != '') ? $request->get('clinic_rate') : '');
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        if($request->isXmlHttpRequest() && $request->get('banner') != '') {
            $ssFlag = (($request->get('ssFlag') != '') ? $request->get('ssFlag') : '');
            $asBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getAddBannerDetail('home_right',
                $snCategoryIds, $ssFlag, $ssCityName, '', $locale);
            return $this->render('ClientMedicalBundle:News:banners.html.twig', array('asBannerDetail'=>$asBannerDetail, 'ssPage' => 'company_listing'));
        }
        $asMiddleBannerDetail = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getAddBannerDetail('company_center',
            $snCategoryIds, '' , $ssCityName, 'mid', $locale);
        $asCompanyData = $em->getRepository('AdminMedicalBundle:Company')->getCompanyAllDetailForSearch_new($ssSerachParam,$ssCityName,
            $ssPaymentOption,$ssLanguages,$ssLocale);
        foreach($asCompanyData[0] as $key => $value) {
            $nameEditor = new NameEditor;
            $companyimg = $em->getRepository('AdminMedicalBundle:Company')->getCompanyImag($value['id']);
            $asCompanyData[0][$key]['companyimag'] = $companyimg;
            $asCompanyData[0][$key]['categoryName'] = $asCompanyData[1][$key];
            $asCompanyData[0][$key]['categoryNameRoute'] = $nameEditor->addDashBetweenWords($asCompanyData[1][$key]);
            $asCompanyData[0][$key]['categoryid'] = $asCompanyData[3][$key];
            $asCompanyData[0][$key]['city'] = $asCompanyData[2][$key];
            $asCompanyData[0][$key]['minprice'] = $asCompanyData[4][$key];
            $asCompanyData[0][$key]['maxprice'] = $asCompanyData[5][$key];
        }

        $asCategoryDataInRecursive = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryDetail($ssLocale, 1);
        $arrayOfCategories = [];
        foreach($asCategoryDataInRecursive as $key=>$val) {
            $replaced = str_replace(["-", "--"], "", $val);
            $arrayOfCategories[] = $replaced;
        }
        $allCategories = json_encode(array_values($arrayOfCategories));


        $snCount = ((count($asCompanyData[0]) < 10) ? (count($asCompanyData[0]) / 2) : ($ssPerPage / 2));
        array_splice($asCompanyData[0], $snCount, 0, $asMiddleBannerDetail);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($asCompanyData[0],$ssPage,$ssPerPage);
        $ssUpdateDiv = 'company_listing_div';
        $pagination->setCustomParameters(array('ssUpdateDiv' => $ssUpdateDiv,'ssPerPage' => $ssPerPage));
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($request->isXmlHttpRequest()) {
            return $this->render('ClientMedicalBundle:Company:companylistingnew.html.twig', array(
                'ssRatingPopular'=>$ssRatingPopular,
                'locale' => $ssLocale,
                'ssPage' => $ssPage,
                'ssUpdateDiv'=>$ssUpdateDiv,
                'pagination' => $pagination,
                'snCategoryIds'=>$snCategoryIds,
                'ssCityName'=>$ssCityName,
                'allCategories' => $allCategories,
                'ssPerPage'=>$ssPerPage));
        } else {
            return $this->render('ClientMedicalBundle:Company:index.html.twig', array(
                'ssPaymentOption'=>$ssPaymentOption,
                'ssClinicRating'=>$ssClinicRating,
                'ssCityName'=>$ssCityName,
                'ssLanguages'=>$ssLanguages,
                'ssRatingPopular'=>$ssRatingPopular,
                'locale' => $ssLocale,
                'pagination' => $pagination,
                'ssPage' => $ssPage,
                'ssSerachParam' => $ssSerachParam,
                'ssUpdateDiv'=>$ssUpdateDiv,
                'snCategoryIds'=>$snCategoryIds,
                'snNewsCategoryIds'=>$snNewsCategoryIds,
                'ssPerPage'=>$ssPerPage,
                'allCategories' => $allCategories,
                'asMetaData'=>$asMetaData
            ));
        }
    }

    public function refinesearchlistAction($ssPage, $ssPerPage) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $em = $this->getDoctrine()->getManager();
        $asLanguageData = $em->getRepository('AdminMedicalBundle:Languages')->getLanguageDetail();
        $asPaymentOptionData = $em->getRepository('AdminMedicalBundle:PaymentOption')->getPaymentDetail();
        $asCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllCategoryDetail($ssLocale, '');
        $asCompanyCityData = $em->getRepository('AdminMedicalBundle:City')->findAll();
        $asLatestFiveInsuranceData = $em->getRepository('AdminMedicalBundle:Company')->getInsuranceDetail($ssLocale);
        $form   = $this->createForm(new InsuranceType($this->container));
        $ssUpdateDiv = 'company_listing_div';

        return $this->render('ClientMedicalBundle:Company:refinesearchlist.html.twig', array(
            'form'=>$form->createView(),
            'asCategoryData' => $asCategoryData,
            'asCompanyCityData' => $asCompanyCityData,
            'asLatestFiveInsuranceData' => $asLatestFiveInsuranceData,
            'ssPage' => $ssPage,
            'ssUpdateDiv' => $ssUpdateDiv,
            'asLanguageData' => $asLanguageData,
            'asPaymentOptionData' => $asPaymentOptionData,
            'ssPerPage' => $ssPerPage
        ));
    }

    public function companydetailAction(Request $request,$id) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $em = $this->getDoctrine()->getManager();
        $asCompanyDetail = $em->getRepository('AdminMedicalBundle:Company')->getCompanyDetailById($id, $ssLocale);
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 10);
        $paginator  = $this->get('knp_paginator');
        $this->get('session')->set('companydetailpage', $id);
        $pagination = $paginator->paginate($asCompanyDetail[0][0]['doctors'],$ssPage,$ssPerPage);
        $ssUpdateDiv = 'doctors';
        $pagination->setUsedRoute('client_medical_company_detail');
        $pagination->setCustomParameters(array('ssUpdateDiv' => $ssUpdateDiv,'ssPerPage' => $ssPerPage, 'id' => $id));
        $form   = $this->createForm(new InsuranceType($this->container));
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($request->isXmlHttpRequest() && $request->get('specialoffer_type') != '') {
            $em->getRepository('AdminMedicalBundle:SpecialOffers')->updatespecialofferwithexpire();
            return $this->render('ClientMedicalBundle:Company:companyspecialoffer.html.twig', array(
                'asCompanyDetail'=>$asCompanyDetail,
                'form' => $form->createView(),
                'ssRoute'=>'client_medical_company_detail'
            ));
        } else if($request->isXmlHttpRequest() && isset($ssPage)){
            return $this->render('ClientMedicalBundle:Company:companydoctors.html.twig', array(
                'asCompanyDetail'=>$asCompanyDetail,
                'form' => $form->createView(),
                'ssRoute'=>'client_medical_company_detail',
                'asMetaData'=>$asMetaData,
                'pagination' => $pagination,
                'ssPage' => $ssPage,
                'ssUpdateDiv'=>$ssUpdateDiv
            ));
        } else {
            return $this->render('ClientMedicalBundle:Company:companydetail.html.twig', array(
                'asCompanyDetail'=>$asCompanyDetail,
                'form' => $form->createView(),
                'ssRoute'=>'client_medical_company_detail',
                'asMetaData'=>$asMetaData,
                'pagination' => $pagination,
                'ssPage' => $ssPage,
                'ssUpdateDiv'=>$ssUpdateDiv
            ));
        }
    }

    public function changelanguageAction(Request $request) {
        $locale = $request->get('locale');
        $this->get('session')->set('_locale', $locale);
        $ssReferer = $this->get('request')->server->get('HTTP_REFERER');

        return $this->redirect($ssReferer);
    }

    public function insurancedetailAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $snCountryId = $request->get('country_id');
        $snCompanyId = $request->get('company_id');
        $em = $this->getDoctrine()->getManager();
        $asCompanyData = $em->getRepository('AdminMedicalBundle:Company')->getInsuranceDetailByCompanyIdAndCountryId($snCompanyId, $snCountryId, $ssLocale);
        $asData = ((is_array($asCompanyData) && !empty($asCompanyData)) ? $asCompanyData : array());
        return $this->render('ClientMedicalBundle:Company:insurancelisting.html.twig', array('asCompanyData'=>$asData));
    }

    public function saveusercompanyAction(Request $request) {
        $snIdCompany = $request->get('id');
        $dd = $this->get('session')->get('company_ids');
        if((is_array($dd) && empty($dd)) || $dd == '') {
            $this->get('session')->set('company_ids', array($snIdCompany));
        } else {
            $asData = $this->get('session')->get('company_ids');
            array_push($asData, $snIdCompany);
            $this->get('session')->set('company_ids', $asData);
        }
        if($request->isXmlHttpRequest()) {
            echo count($this->get('session')->get('company_ids'));exit;
        }
    }

    public function savedcompanyAction() {
        $snCount = (($this->get('session')->get('company_ids') != '' && count(
                $this->get('session')->get('company_ids')) != 0) ? count($this->get('session')->get('company_ids')) : 0
        );
        return $this->render('ClientMedicalBundle:Company:savedcompany.html.twig', array('snCount'=>$snCount));
    }

    public function usercompanyAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 10);
        $em = $this->getDoctrine()->getManager();
        $asCompanyData = $em->getRepository('AdminMedicalBundle:Company')->getCompanyDetailByIds($this->get('session')->get('company_ids'), $ssLocale);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($asCompanyData,$ssPage,$ssPerPage);
        $pagination->setUsedRoute('client_medical_user_company');
        $pagination->setCustomParameters(array('ssUpdateDiv' => 'user_company_wishlist','ssPerPage'=>$ssPerPage));
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($request->isXmlHttpRequest()) {
            return $this->render('ClientMedicalBundle:Company:usercompanywishlist.html.twig', array('pagination' => $pagination));
        } else {
            return $this->render('ClientMedicalBundle:Company:usercompany.html.twig', array('pagination'=>$pagination, 'asMetaData'=>$asMetaData));
        }
    }

    public function removeusercompanyAction(Request $request){
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $em = $this->getDoctrine()->getManager();
        $snIdUserCompany = $request->get('id');
        $asData = $this->get('session')->get('company_ids');
        $snKey = array_search($snIdUserCompany,$asData);
        unset($asData[$snKey]);
        $this->get('session')->set('company_ids', $asData);
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 10);
        $asCompanyData = $em->getRepository('AdminMedicalBundle:Company')->getCompanyDetailByIds($asData, $ssLocale);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($asCompanyData,$ssPage,$ssPerPage);
        $pagination->setUsedRoute('client_medical_user_company');
        $pagination->setCustomParameters(array('ssUpdateDiv' => 'user_company_wishlist','ssPerPage'=>$ssPerPage));
        if($request->isXmlHttpRequest()) {
            return $this->render('ClientMedicalBundle:Company:usercompanywishlist.html.twig', array('pagination' => $pagination));
        }
    }

    public function sendquoteAction(Request $request) {
        $asCompanyIds = $this->get('session')->get('company_ids');
        if(empty($asCompanyIds)) {
            return $this->redirect($this->generateUrl('client_medical_homepage'));
        }
        $em = $this->getDoctrine()->getManager();
        $formImage = $this->createForm(new QuoteDocumentsType());
        $snQuoteId = (($request->get('quote_id') != '') ? $request->get('quote_id') : '');
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($snQuoteId != '') {
            $entity = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->find(base64_decode($snQuoteId));
        } else {
            $entity = new UserQuoteDetail();
        }
        $form = $this->createForm(new QuoteType($this->container), $entity);
        if ($request->isMethod('POST')) {
            $session = $request->getSession();
            $form->bind($request);
            $asFormData = $request->get('client_medicalbundle_user_quote_detail');
            if(
                $asFormData['firstname'] == '' ||
                $asFormData['lastname'] == '' ||
                $asFormData['email'] == '' ||
                $asFormData['countries'] == '' ||
                $asFormData['health_problem'] == '' ||
                !isset($asFormData['categories'])
            ) {
                $ssQuoteStatus = 'unverified';
                $translated = $this->get('translator')->trans('Please, fill all required fields. All required fields are marked with "*"');
                $session->getFlashBag()->add('error', $translated);
            } else {
                $ssQuoteStatus = 'active';
            }
            $asLastQuotesData = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->findBy(array(),array('id'=>'DESC'),1);
            if(isset($asLastQuotesData) && count($asLastQuotesData) > 0) {
                $asData = $asLastQuotesData[0];
                $snDigit = $asData->getId() + 1;
                if(strlen($snDigit) == 1) {
                    $snDigit = '00'.$snDigit;
                } elseif(strlen($snDigit) == 2) {
                    $snDigit = '0'.$snDigit;
                } else {
                    $snDigit = $snDigit;
                }
                $ssUniqueId = $snDigit.date('dmy');
            } else {
                $ssUniqueId = date('dmy');
            }
            $entity->setClientIPAddress($this->container->get('request')->getClientIp());
            $entity->setQuoteStatus($ssQuoteStatus);
            $entity->setUniqueId($ssUniqueId);
            $entity->setCheckedByAdmin('No');
            $em->persist($entity);
            $em->flush();
            $formImage->bind($request);
            $data = $formImage->getData();
            $asData = $data->getdocuments();
            $allowedExts = array("pdf","doc","csv","xls","docx","txt","jpg", "jpeg", "png", "bmp");
            if(isset($asData[0]) && count($asData[0]) > 0) {
                $ssFolderPath = $this->container->getParameter('web_path').'documents/';
                if(!is_dir($ssFolderPath)) {
                    mkdir($ssFolderPath, 0777);
                }
                $ssPath = $ssFolderPath.$entity->getId().'/';
                if(!is_dir($ssPath)) {
                    mkdir($ssPath, 0777);
                }
            }
            $asDescriptionData = $data->getdescription();
            $ssFlag = true;
            foreach($asData as $snKey=>$file) {
                if(count($asData[$snKey]) > 0) {
                    $ssFilename = $file->getClientOriginalName();
                    $asExtension = explode(".",$ssFilename);
                    if(!in_array($asExtension[count($asExtension) - 1], $allowedExts)) {
                        $ssFlag = false;
                        break;
                    }
                }
            }
            if($ssFlag) {
                foreach($asData as $snKey=>$file) {
                    if(count($asData[$snKey]) > 0) {
                        $ssFilename = $file->getClientOriginalName();
                        $ssTempFilePath = $file->getPathName();
                        $ssImagePath = $ssPath.$ssFilename;
                        move_uploaded_file($ssTempFilePath, $ssImagePath);
                        $oDocuments = new UserQuoteDocuments();
                        $oDocuments->setUserQuoteDetails($entity);
                        $oDocuments->setDocuments($ssFilename);
                        $oDocuments->setDescription($asDescriptionData[$snKey]);
                        $em->persist($oDocuments);
                    }
                }
            } else {
                $translated = $this->get('translator')->trans('Document only allowed with these formatted files "pdf","doc","csv","xls","docx","txt","jpg", "jpeg", "png", "bmp"');
                $session->getFlashBag()->add('error', $translated);
            }
            $em->flush();
            if($ssQuoteStatus == 'active' && $ssFlag == true) {
                $asCompanyIds = $this->get('session')->get('company_ids');
                if(count($asCompanyIds) > 0) {
                    foreach($asCompanyIds as $snId) {
                        $oCompany = $em->getRepository('AdminMedicalBundle:Company')->findOneById($snId);
                        $objUserCompanyQuotes = new UserCompanyQuotes();
                        $objUserCompanyQuotes->setCompany($oCompany);
                        $objUserCompanyQuotes->setUserQuoteDetails($entity);
                        $em->persist($objUserCompanyQuotes);
                        $em->flush();
                        $objComm = new UserCompanyCommunication();
                        $objComm->setCompany($oCompany);
                        $objComm->setUserquotedetails($entity);
                        $objComm->setUserType('user');
                        $objComm->setReplyType('No');
                        $em->persist($objComm);
                        $em->flush();
                    }
                }
                $this->get('session')->set('company_ids',array());
                $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('QUOTE_WAS_RECEIVED');
                $asMailContent = $oNewMailData->getDescription();
                $ssMailContent = str_replace("{FIRSTNAME}",$asFormData['firstname'],$asMailContent);
                $ssMailContent = str_replace("{LASTNAME}",$asFormData['lastname'],$ssMailContent);
                $ssMailContent = str_replace("{PHONE}",$asFormData['phone'],$ssMailContent);
                $ssMailContent = str_replace("{HEALTH_PROBLEM}",$asFormData['health_problem'],$ssMailContent);
                $URL = $this->container->getParameter('site_url').'client/communication/'.$entity->getId().'/'.$asCompanyIds[count($asCompanyIds) - 1];
                $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                $ssMailContent = str_replace("{COMMUNICATION_URL}", $ssURL, $ssMailContent);
                $this->sendmail($asFormData['email'], $ssMailContent, $oNewMailData->getTitle());
                return $this->redirect($this->generateUrl('client_medical_sendquotesuccess'));
            } else
                return $this->redirect($this->generateUrl('client_medical_sendquote',array('quote_id'=>base64_encode($entity->getId()))));
        }
        if($snQuoteId != '') {
            $asQuoteCompanyDocumentsData = $em->getRepository('AdminMedicalBundle:UserQuoteDocuments')->getCompanyQuotesDocumentsByQuoteDetailId(base64_decode($snQuoteId));
        } else {
            $asQuoteCompanyDocumentsData = array();
        }
        return $this->render('ClientMedicalBundle:Company:sendquote.html.twig',array(
            'asMetaData'=>$asMetaData,
            'form'=>$form->createView(),
            'formImage'=>$formImage->createView(),
            'asQuoteCompanyDocumentsData'=>$asQuoteCompanyDocumentsData,
            'snQuoteId'=>base64_decode($snQuoteId)
        ));
    }

    public function sendquotesuccessAction(){
        return $this->render('ClientMedicalBundle:Company:sendquotesuccess.html.twig');
    }

    public function sendquotepopupAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $formImage = $this->createForm(new QuoteDocumentsType());
        $snQuoteId = (($request->get('quote_id') != '') ? $request->get('quote_id') : '');
        if($snQuoteId != '') {
            $entity = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->find($snQuoteId);
        } else {
            $entity = new UserQuoteDetail();
        }
        $form = $this->createForm(new QuoteType($this->container), $entity);
        if($snQuoteId != '') {
            $asQuoteCompanyDocumentsData = $em->getRepository('AdminMedicalBundle:UserQuoteDocuments')->getCompanyQuotesDocumentsByQuoteDetailId($snQuoteId);
        } else {
            $asQuoteCompanyDocumentsData = array();
        }
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            $asFormData = $request->get('client_medicalbundle_user_quote_detail');
            $session = $request->getSession();
            if(
                $asFormData['firstname'] == '' ||
                $asFormData['lastname'] == '' ||
                $asFormData['email'] == '' ||
                $asFormData['countries'] == '' ||
                $asFormData['health_problem'] == '' ||
                !isset($asFormData['categories'])
            ) {
                $ssQuoteStatus = 'unverified';
                $translated = $this->get('translator')->trans('Please, fill all required fields. All required fields are marked with "*"');
                $session->getFlashBag()->add('error', $translated);
            } else {
                $ssQuoteStatus = 'active';
            }
            $asLastQuotesData = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->findBy(array(),array('id'=>'DESC'),1);
            if(isset($asLastQuotesData) && count($asLastQuotesData) > 0) {
                $asData = $asLastQuotesData[0];
                $snDigit = $asData->getId() + 1;
                if(strlen($snDigit) == 1) {
                    $snDigit = '00'.$snDigit;
                } elseif(strlen($snDigit) == 2) {
                    $snDigit = '0'.$snDigit;
                } else {
                    $snDigit = $snDigit;
                }
                $ssUniqueId = $snDigit.date('dmy');
            } else {
                $ssUniqueId = date('dmy');
            }
            $entity->setClientIPAddress($this->container->get('request')->getClientIp());
            $entity->setQuoteStatus($ssQuoteStatus);
            $entity->setUniqueId($ssUniqueId);
            $entity->setCheckedByAdmin('No');
            $em->persist($entity);
            $em->flush();
            $formImage->bind($request);
            $data = $formImage->getData();
            $asData = $data->getdocuments();
            $allowedExts = array("pdf","doc","csv","xls","docx","txt","jpg", "jpeg", "png", "bmp");
            if(isset($asData[0]) && count($asData[0]) > 0) {
                $ssFolderPath = $this->container->getParameter('web_path').'documents/';
                if(!is_dir($ssFolderPath)) {
                    mkdir($ssFolderPath, 0777);
                }
                $ssPath = $ssFolderPath.$entity->getId().'/';
                if(!is_dir($ssPath)) {
                    mkdir($ssPath, 0777);
                }
            }
            $asDescriptionData = $data->getdescription();
            $ssFlag = true;
            foreach($asData as $snKey=>$file) {
                if(count($asData[$snKey]) > 0) {
                    $ssFilename = $file->getClientOriginalName();
                    $asExtension = explode(".",$ssFilename);
                    if(!in_array($asExtension[count($asExtension) - 1], $allowedExts)) {
                        $ssFlag = false;
                        break;
                    }
                }
            }
            if($ssFlag) {
                foreach($asData as $snKey=>$file) {
                    if(count($asData[$snKey]) > 0) {
                        $ssFilename = $file->getClientOriginalName();
                        $ssTempFilePath = $file->getPathName();
                        $ssImagePath = $ssPath.$ssFilename;
                        move_uploaded_file($ssTempFilePath, $ssImagePath);
                        $oDocuments = new UserQuoteDocuments();
                        $oDocuments->setUserQuoteDetails($entity);
                        $oDocuments->setDocuments($ssFilename);
                        $oDocuments->setDescription($asDescriptionData[$snKey]);
                        $em->persist($oDocuments);
                    }
                }
            } else {
                $translated = $this->get('translator')->trans('Document only allowed with these formatted files "pdf","doc","csv","xls","docx","txt","jpg", "jpeg", "png", "bmp"');
                $session->getFlashBag()->add('error', $translated);
            }
            $em->flush();
            if($ssQuoteStatus == 'active' && $ssFlag == true) {
                $snId = (($request->get('id') != '') ? $request->get('id') : '');
                if($snId != '') {
                    $oCompany = $em->getRepository('AdminMedicalBundle:Company')->findOneById($snId);
                    $objUserCompanyQuotes = new UserCompanyQuotes();
                    $objUserCompanyQuotes->setCompany($oCompany);
                    $objUserCompanyQuotes->setUserQuoteDetails($entity);
                    $em->persist($objUserCompanyQuotes);
                    $em->flush();
                    $objComm = new UserCompanyCommunication();
                    $objComm->setCompany($oCompany);
                    $objComm->setUserquotedetails($entity);
                    $objComm->setUserType('user');
                    $objComm->setReplyType('No');
                    $em->persist($objComm);
                    $em->flush();
                    $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('QUOTE_WAS_RECEIVED');
                    $asMailContent = $oNewMailData->getDescription();
                    $ssMailContent = str_replace("{FIRSTNAME}",$asFormData['firstname'],$asMailContent);
                    $ssMailContent = str_replace("{LASTNAME}",$asFormData['lastname'],$ssMailContent);
                    $ssMailContent = str_replace("{PHONE}",$asFormData['phone'],$ssMailContent);
                    $ssMailContent = str_replace("{HEALTH_PROBLEM}",$asFormData['health_problem'],$ssMailContent);
                    $URL = $this->container->getParameter('site_url').'client/communication/'.$entity->getId().'/'.$snId;
                    $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                    $ssMailContent = str_replace("{COMMUNICATION_URL}", $ssURL, $ssMailContent);
                    $this->sendmail($asFormData['email'], $ssMailContent, $oNewMailData->getTitle());
                    $ssFlag = true;
                }
                if($ssFlag) {
                    echo '<script type="text/javascript">window.location.href="'.$this->container->getParameter('site_url').'client/success'.'"</script>';exit;
                } else {
                    return $this->render('ClientMedicalBundle:Company:sendquotepopup.html.twig',array(
                        'quote_id'=>$entity->getId(),
                        'form'=>$form->createView(),
                        'formImage'=>$formImage->createView(),
                        'asQuoteCompanyDocumentsData'=>$asQuoteCompanyDocumentsData
                    ));
                }
            } else {
                return $this->render('ClientMedicalBundle:Company:sendquotepopup.html.twig',array(
                    'quote_id'=>$entity->getId(),
                    'form'=>$form->createView(),
                    'formImage'=>$formImage->createView(),
                    'asQuoteCompanyDocumentsData'=>$asQuoteCompanyDocumentsData
                ));
            }
        }
        return $this->render('ClientMedicalBundle:Company:sendquotepopup.html.twig',array(
            'quote_id'=>$entity->getId(),
            'form'=>$form->createView(),
            'formImage'=>$formImage->createView(),
            'asQuoteCompanyDocumentsData'=>$asQuoteCompanyDocumentsData
        ));
    }

    public function specialoffersAction($ssRoute) {
        $locale = $this->get('session')->get('_locale');
        if($locale == '') {
            $locale = $this->get('session')->set('_locale', 'en');
        }
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AdminMedicalBundle:SpecialOffers')->updatespecialofferwithexpire();
        $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale,'',true);
        return $this->render('ClientMedicalBundle:Company:specialoffers.html.twig', array('asSpecialOffersData'=>$asSpecialOffersData,'ssRoute'=>$ssRoute));
    }

    public function alllanguagesAction() {
        $em = $this->getDoctrine()->getManager();
        $asAllLanguagesData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
        return $this->render('ClientMedicalBundle:Company:alllanguages.html.twig', array('asAllLanguagesData' => $asAllLanguagesData));
    }

    public function sendmail($to, $ssBody, $ssSubject){
        $message = \Swift_Message::newInstance()
            ->setContentType("text/html")
            ->setSubject($ssSubject)
            ->setFrom('noreply@medical.lt')
            ->setTo($to)
            ->setBody($ssBody);

        $this->get('mailer')->send($message);
    }

    public function updatebannercountAction(Request $request){
        if($request->isXmlHttpRequest()) {
            echo "success";exit;
        }
        echo "fail";exit;
    }
}
