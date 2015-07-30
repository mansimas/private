<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\MedicalBundle\Entity\Ratings;
use Admin\MedicalBundle\Form\RatingsType;
use Symfony\Component\HttpFoundation\Session\Session;

class RatingController extends Controller
{
    public function indexAction(Request $request) {
        $asRatingData = array();
        $snIdCompany = $request->get('id');
        $snFromTab = ($request->get('from_tab')) ? $request->get('from_tab') : 0;
        $em = $this->getDoctrine()->getManager();
        if(isset($snIdCompany) && $snIdCompany != '') {
            $asRatingData = $em->getRepository('AdminMedicalBundle:Ratings')->getRatingDetail($snIdCompany, true);
        }
        $ssPage = (($request->get('page') != '') ? $request->get('page') : 1);
        $ssPerPage = (($request->get('per_page') != '') ? $request->get('per_page') : 10);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($asRatingData,$ssPage,$ssPerPage);
        $pagination->setUsedRoute('client_medical_rating');
        $ssUpdateDiv = 'rating_listing';
        $pagination->setCustomParameters(array('ssUpdateDiv' => $ssUpdateDiv,'ssPerPage'=>$ssPerPage));
        if($request->isXmlHttpRequest() && $request->get('ss_flag') == true) {
            return $this->render('ClientMedicalBundle:Rating:ratinglisting.html.twig', array('pagination' => $pagination, 'snFromTab'=>$snFromTab));
        } else {
            return $this->render('ClientMedicalBundle:Rating:index.html.twig', array(
                'pagination' => $pagination,
                'ssPage' => $ssPage,
                'ssUpdateDiv'=>$ssUpdateDiv,
                'snFromTab'=>$snFromTab
            ));
        }
    }

    public function addratingAction(Request $request, $id) {
        $oRatings = new Ratings();
        $objRatings = $this->createForm(new RatingsType(), $oRatings);
        if($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $snIdCompany = $id;
            if(isset($snIdCompany) && $snIdCompany != '') {
                $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);
            }
            $objRatings->bind($request);
            if ($objRatings->isValid()) {
                $snDate = new \DateTime(date('Y-m-d H:i:s'));
                $oRatings->setRatingDate($snDate);
                $oRatings->setCompany($entity);
                $oRatings->setVerifyFlag(0);
                $em->persist($oRatings);
                $em->flush();
                return $this->render('ClientMedicalBundle:Rating:successmessage.html.twig',array('snConpanyId' => $snIdCompany));
            }
        } else {
            return $this->render('ClientMedicalBundle:Rating:addrating.html.twig', array('objRatings' => $objRatings->createView()));
        }
    }

    public function mailaddratingAction(){
        $oRatings = new Ratings();
        $objRatings = $this->createForm(new RatingsType(), $oRatings);
        return $this->render('ClientMedicalBundle:Rating:mailaddrating.html.twig', array('objRatings' => $objRatings->createView()));
    }
}
