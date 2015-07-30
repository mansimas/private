<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Admin\MedicalBundle\Entity\Doctor;

class DoctorController extends Controller
{

    public function indexAction() {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $this->get('session')->set('companydetailpage', 0);
        $em = $this->getDoctrine()->getManager();
        $asDoctorData = $em->getRepository('AdminMedicalBundle:Doctor')->getAllDoctorsInBlock($ssLocale);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);

        return $this->render('ClientMedicalBundle:Doctor:index.html.twig',array('asDoctorData' => $asDoctorData,'asMetaData' => $asMetaData));
    }

    public function doctordetailAction(Request $request) {
        $snDoctorId = $request->get('id');
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asDoctorData = $em->getRepository('AdminMedicalBundle:Doctor')->getAllDoctorDetail($ssLocale,$snDoctorId);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        $asCompanyByDoctorData = $em->getRepository('AdminMedicalBundle:Company')->getCompanyByDoctorId($ssLocale, $snDoctorId);
        if($request->isXmlHttpRequest()) {
            $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale,'',true);
            return $this->render('ClientMedicalBundle:Company:specialoffers.html.twig', array('asSpecialOffersData'=>$asSpecialOffersData,'ssRoute'=>'client_medical_doctor_detail'));
        } else {
            return $this->render('ClientMedicalBundle:Doctor:doctordetail.html.twig', array(
                'asDoctorData'=>$asDoctorData,
                'asCompanyByDoctorData'=>$asCompanyByDoctorData,
                'ssRoute'=>'client_medical_doctor_detail',
                'asMetaData' => $asMetaData
            ));
        }
    }
}
