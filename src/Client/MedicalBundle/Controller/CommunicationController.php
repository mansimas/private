<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\MedicalBundle\Entity\UserCompanyCommunication;
use Clinic\CommunicationBundle\Form\ClinicReplyType;
use Client\MedicalBundle\Form\FinalReservationType;

class CommunicationController extends Controller
{
    public function indexAction(Request $request) {
        $quote_id = $request->get('quote_id');
        if($quote_id == '') {
            throw $this->createNotFoundException("Sorry not found.");
        }
        $snCompanyId = $request->get('company_id');
        $em = $this->getDoctrine()->getManager();
        $oQuoteDetail = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->findOneById($quote_id);
        $this->get('session')->set('quote_id', $quote_id);
        $this->get('session')->set('comp_id', $snCompanyId);
        $asQuoteStatus = array();
        if($snCompanyId != '') {
            $asQuoteStatus = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getCompanyWiseQuoteStatus($quote_id, $snCompanyId);
        }
        if((is_array($asQuoteStatus) && !empty($asQuoteStatus) && $asQuoteStatus[0]['quote_status'] == 'archive') || $asQuoteStatus[0]['paypal_payment_status'] == 1) {
            throw $this->createNotFoundException("Sorry not found.");
        }
        if(
            $oQuoteDetail->getQuoteStatus() == 'archive' ||
            $oQuoteDetail->getQuoteStatus() == 'blocked' ||
            $oQuoteDetail->getQuoteStatus() == 'unverified' ||
            $oQuoteDetail->getQuoteStatus() == 'Completed') {
            throw $this->createNotFoundException("Sorry not found.");
        }
        $objComm = new UserCompanyCommunication();
        $form = $this->createForm(new ClinicReplyType(), $objComm);
        $asCommunicationDetail = array();
        if($snCompanyId != '') {
            $asCommunicationDetail = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getCompanyCommunicationDetail($quote_id, $snCompanyId);
            $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateDataByField($quote_id, $snCompanyId, 'company');
        }
        if($request->isXmlHttpRequest()) {
            return $this->render('ClientMedicalBundle:Communication:communication.html.twig', array('form'=>$form->createView(), 'asCommunicationDetail' => $asCommunicationDetail, 'quote_id'=>$quote_id, 'oQuoteDetail'=>$oQuoteDetail));
        }
        $asCompanyDetail = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getQuotewiseCompanyDetail($quote_id);

        return $this->render('ClientMedicalBundle:Communication:index.html.twig', array('form'=>$form->createView(), 'asCommunicationDetail'=>$asCommunicationDetail, 'quote_id'=>$quote_id,'oQuoteDetail'=>$oQuoteDetail,'asCompanyDetail'=>$asCompanyDetail));
    }

    public function clientreplyAction(Request $request) {
        $objComm = new UserCompanyCommunication();
        $em = $this->getDoctrine()->getManager();
        $snIdQuote = $request->get('quote_id');
        $snIdCompany = $request->get('company_id');
        $form = $this->createForm(new ClinicReplyType(), $objComm);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $oCompany = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);
                $oQuote = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->find($snIdQuote);
                $objComm->setCompany($oCompany);
                $objComm->setUserquotedetails($oQuote);
                $objComm->setUserType('user');
                $objComm->setCheckedByClient('No');
                $objComm->setReplyType('No');
                $em->persist($objComm);
                $em->flush();
                $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateReplyType($snIdQuote, $snIdCompany,'company');
                $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField($snIdQuote, $snIdCompany, 'in_progress', 'quote_status');
                $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('NEW_MESSAGE_FROM_CLIENT');
                $asData = $oNewMailData->getDescription();
                $ssMailContent = str_replace("{FIRSTNAME}",$oQuote->getFirstname(),$asData);
                $ssMailContent = str_replace("{LASTNAME}",$oQuote->getLastname(),$ssMailContent);
                $ssMailContent = str_replace("{HEALTH_PROBLEM}",$oQuote->getHealthProblem(),$ssMailContent);
                $URL = $this->container->getParameter('site_url').'clinic/communication/'.$snIdQuote;
                $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                $ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);
                $this->sendmail($oCompany->getEmail(), $ssMailContent, $oNewMailData->getTitle());

                return $this->redirect($this->generateUrl('client_communication', array('quote_id' => $snIdQuote,'company_id'=>$snIdCompany)));
            }
        }
    }

    public function finalreservationAction(Request $request) {
        $snQuoteId = $request->get('quote_id');
        $snCompanyId = $request->get('company_id');
        $em = $this->getDoctrine()->getManager();
        $oQuoteInfo = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->findOneById($snQuoteId);
        $asQuoteOfferInfo = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getCommunicationDetail($snQuoteId, $snCompanyId,'company');
        $snReservationFee = 0;
        if(isset($asQuoteOfferInfo[0]) && count($asQuoteOfferInfo[0]['company']) > 0) {
            $snReservationFee = $em->getRepository('AdminMedicalBundle:Company')->calculateReservationFee($asQuoteOfferInfo[0]['company'], $asQuoteOfferInfo[0]['service_price']);
        }
        $istwentyfour= $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->findOneBy(array(
            'userquotedetails' => $snQuoteId,
            'company' => $snCompanyId,
            'quote_status' => 'twenty_four'
        ));
        $form = $this->createForm(new FinalReservationType($this->container), $oQuoteInfo);
        if ($request->isMethod('POST')) {
            $asQuotesdata = $request->request->all();
            $asQuotesdata = $asQuotesdata['client_medicalbundle_final_reservation'];
            $form->bind($request);
            if($form->isValid()) {
                $em->persist($oQuoteInfo);
                $em->flush();
                $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateData(
                    $snQuoteId,
                    $snCompanyId,
                    $asQuotesdata,
                    $oQuoteInfo->getUniqueId(),
                    $asQuoteOfferInfo[0]['service_price'],
                    $asQuoteOfferInfo[0]['reservation_date']->format('Y-m-d'),
                    $asQuoteOfferInfo[0]['reservation_time']->format('H:i:s'),
                    $istwentyfour
                );
            }
            return $this->redirect($this->generateUrl('client_communication_payment',array('quote_id'=>$snQuoteId,'company_id'=>$snCompanyId)));
        }
        $asReservationData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getQuoteReservationDetail($snQuoteId, $snCompanyId);
        $session = $request->getSession();
        if(count($asReservationData) > 0) {
            if($asReservationData[0]['paypal_payment_status'] == 1 && $asReservationData[0]['reservation_id'] != '') {
                $translated = $this->get('translator')->trans('Your payment done successfully');
                $session->getFlashBag()->add('success', $translated);
            } else if($asReservationData[0]['paypal_payment_status'] == 2) {
                $translated = $this->get('translator')->trans('Your payment is failed, try again!');
                $session->getFlashBag()->add('failure', $translated);
            }
        }

        return $this->render('ClientMedicalBundle:Communication:finalreservation.html.twig',array(
            'form' => $form->createView(),
            'oQuoteInfo'=>$oQuoteInfo,
            'asQuoteOfferInfo'=>$asQuoteOfferInfo,
            'asReservationData'=>$asReservationData,
            'snReservationFee'=>$snReservationFee,
            'istwentyfour'=>$istwentyfour
        ));
    }

    public function paymentAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $snQuoteId = $request->get('quote_id');
        $snCompanyId = $request->get('company_id');
        $asQuoteOfferInfo = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getCommunicationDetail($snQuoteId, $snCompanyId,'company');
        if(isset($asQuoteOfferInfo[0]) && count($asQuoteOfferInfo[0]['company']) > 0) {
            // should return something
        }
        echo "";
        exit;
    }

    public function successreservationAction($quote_id, $company_id){
        $em = $this->getDoctrine()->getManager();
        $params = array();
        parse_str(base64_decode(strtr($_GET['data'], array('-' => '+', '_' => '/'))), $params);
        $snTransactionId = $params['requestid'];
        $ssPaymentStatus = $params['status'];
        if($ssPaymentStatus == 1 || $ssPaymentStatus == 2) {
            $ssPaymentStatus = 1;
            $oQuote = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->findOneById($quote_id);
            $asQuoteOfferInfo = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getCommunicationDetail($quote_id, $company_id,'company');
            $asQuoteOfferInfo = $asQuoteOfferInfo[0];
            $oCompany = $em->getRepository('AdminMedicalBundle:Company')->find($company_id);
            $objComm = new UserCompanyCommunication();
            $objComm->setCompany($oCompany);
            $objComm->setUserquotedetails($oQuote);
            $objComm->setUserType('user');
            $objComm->setCheckedByClient('No');
            $objComm->setReplyType('Yes');
            $objComm->setReservationType('paid');
            $em->persist($objComm);
            $em->flush();
            $oQuote->setQuoteStatus('Completed');
            $em->persist($oQuote);
            $em->flush();
            $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateReplyType($quote_id, $company_id,'company');
            $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateFinalReservationData($quote_id, $company_id, $snTransactionId, $ssPaymentStatus);
            $asQuoteReservationInfo = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getQuoteReservationDetail($quote_id, $company_id);
            $asCompaniesOfQuote = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getFinalQuotesPriceCompanyByQuoteId($quote_id, $company_id);
            if(is_array($asCompaniesOfQuote) and !empty($asCompaniesOfQuote)) {
                foreach($asCompaniesOfQuote as $snKey=>$asValue) {
                    $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('COMPANY_FINAL_PRICE_INFO');
                    $asData = $oNewMailData->getDescription();
                    $ssMailContent = str_replace("{SERVICE_PRICE}",$asQuoteReservationInfo[0]['service_price'],$asData);
                    $ssMailContent = str_replace("{COMPANY_NAME}",$asValue['company']['name'],$ssMailContent);
                    $this->sendmail($asValue['company']['email'], $ssMailContent, $oNewMailData->getTitle());
                }
            }
            $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('CLIENT_RECEIVES_FINAL_RESERVATION_CONFIRAMTION_AFTER_CHECKOUT');
            $asData = $oNewMailData->getDescription();
            $ssMailContent = str_replace("{RESERVATION_ID}",$asQuoteReservationInfo[0]['reservation_id'],$asData);
            $ssReservationString = '<table "border"=1><tr><td>Address </td><td>'.
                $asQuoteReservationInfo[0]['resi_address_one'].' '.
                $asQuoteReservationInfo[0]['resi_city'].' '.
                $asQuoteReservationInfo[0]['resi_state'].
                '</td></tr></table>';
            $ssMailContent = str_replace("{RESERVATION_INFORMATION}",$ssReservationString,$ssMailContent);
            $ssDocumentPath = $this->generatePDFForReservationInvoice($em, $quote_id, $company_id);
            $ssFileName = $asQuoteReservationInfo[0]['reservation_id'].'.pdf';
            $ssSecondInvoceFileName = 'invoice.pdf';
            $this->sendmail($oQuote->getEmail(), $ssMailContent, $oNewMailData->getTitle(), $ssDocumentPath[0], $ssFileName, $ssDocumentPath[1], $ssSecondInvoceFileName);
            $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('CLIENT_MADE_FINAL_RESERVATION');
            $asData = $oNewMailData->getDescription();
            $ssMailContent = str_replace("{RESERVATION_ID}",$asQuoteReservationInfo[0]['reservation_id'],$asData);
            $ssMailContent = str_replace("{FIRSTNAME}",$oQuote->getFirstname(),$ssMailContent);
            $ssMailContent = str_replace("{LASTNAME}",$oQuote->getLastname(),$ssMailContent);
            $ssMailContent = str_replace("{SERVICE_DESCRIPTION}",$asQuoteOfferInfo['service_description'],$ssMailContent);
            $ssAddress = $asQuoteReservationInfo[0]['resi_address_one'].','.$asQuoteReservationInfo[0]['resi_city'].','.$asQuoteReservationInfo[0]['resi_state'];
            $ssMailContent = str_replace("{FULLADDRESS}",$ssAddress,$ssMailContent);
            $ssMailContent = str_replace("{EMAIL}",$oQuote->getEmail(),$ssMailContent);
            $ssMailContent = str_replace("{PHONE}",$oQuote->getPhone(),$ssMailContent);
            $this->sendmail(
                $asQuoteOfferInfo['company']['email'],
                $ssMailContent, $oNewMailData->getTitle(),
                $ssDocumentPath[0],
                $ssFileName,
                $ssDocumentPath[1],
                $ssSecondInvoceFileName
            );
        }
        return $this->redirect($this->generateUrl('client_final_reservation',array('quote_id'=>$quote_id,'company_id'=>$company_id)));
    }

    public function twentyfourhrsreservationAction(Request $request){
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $snQuoteId = $request->get('quote_id');
        $snCompanyId = $request->get('company_id');
        $em = $this->getDoctrine()->getManager();
        $oQuoteInfo = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->findOneById($snQuoteId);
        $asQuoteOfferInfo = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getCommunicationDetail($snQuoteId, $snCompanyId,'company');
        $form = $this->createForm(new FinalReservationType($this->container));
        if ($request->isMethod('POST')) {
            $asQuotesdata = $request->request->all();
            $asQuotesdata = $asQuotesdata['client_medicalbundle_final_reservation'];
            $form->bind($request);
            if($form->isValid()) {
                $oCompany = $em->getRepository('AdminMedicalBundle:Company')->find($snCompanyId);
                $objComm = new UserCompanyCommunication();
                $objComm->setCompany($oCompany);
                $objComm->setUserquotedetails($oQuoteInfo);
                $objComm->setUserType('user');
                $objComm->setCheckedByClient('No');
                $objComm->setReplyType('Yes');
                $objComm->setReservationType('twenty_four');
                $em->persist($objComm);
                $em->flush();
                $oQuoteInfo->setQuoteStatus('twenty_four');
                $em->persist($oQuoteInfo);
                $em->flush();
                $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateReplyType($snQuoteId, $snCompanyId,'company');
                $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateTwentyFourHrsData(
                    $snQuoteId,
                    $snCompanyId,
                    $asQuotesdata,
                    $oQuoteInfo->getUniqueId(),
                    $asQuoteOfferInfo[0]['service_price'],
                    $asQuoteOfferInfo[0]['reservation_date']->format('Y-m-d')
                );
                $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('24H_RESERVATION_CONFIRMED');
                $asTwentyFourData = $oNewMailData->getDescription();
                $ssMailContent = str_replace("{FIRSTNAME}", $oQuoteInfo->getFirstname(), $asTwentyFourData);
                $ssMailContent = str_replace("{LASTNAME}", $oQuoteInfo->getLastname(), $ssMailContent);
                $snDate = date("Y-m-d H:i:s", strtotime("+ 1 day"));
                $ssMailContent = str_replace("{DATE}", $snDate, $ssMailContent);
                $URL = $this->container->getParameter('site_url').'client/finalreservation/'.$snQuoteId.'/'.$snCompanyId;
                $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                $ssMailContent = str_replace("{COMMUNICATION_URL}", $ssURL, $ssMailContent);
                $this->sendmail($oQuoteInfo->getEmail(), $ssMailContent, $oNewMailData->getTitle());
                $oCompanyInfo = $em->getRepository('AdminMedicalBundle:Company')->findOneById($snCompanyId);
                $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('24H_RESERVATION_RECEIVED_FROM_CLIENT');
                $asTwentyFourDataForClinic = $oNewMailData->getDescription();
                $ssClinicMailContent = str_replace("{FIRSTNAME}", $oQuoteInfo->getFirstname(), $asTwentyFourDataForClinic);
                $ssClinicMailContent = str_replace("{LASTNAME}", $oQuoteInfo->getLastname(), $ssClinicMailContent);
                $ssClinicMailContent = str_replace("{COMPANY_NAME}", $oCompanyInfo->getName(), $ssClinicMailContent);
                $snDate = date("Y-m-d H:i:s", strtotime("+ 1 day"));
                $ssClinicMailContent = str_replace("{DATE}", $snDate, $ssClinicMailContent);
                $this->sendmail($oCompanyInfo->getEmail(), $ssClinicMailContent, $oNewMailData->getTitle());
            }
            return $this->redirect($this->generateUrl('client_thankyou'));
        }
        return $this->render('ClientMedicalBundle:Communication:twentyfourhrsreservation.html.twig',array('form' => $form->createView(),'oQuoteInfo'=>$oQuoteInfo,'locale'=>$ssLocale));
    }

    public function generatePDFForReservationInvoice($em, $snQuoteId, $snCompanyId){
        $asQuoteOfferInfo = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getCommunicationDetail($snQuoteId, $snCompanyId,'company');
        $snReservationFee = 0;
        if(isset($asQuoteOfferInfo[0]) && count($asQuoteOfferInfo[0]['company']) > 0) {
            $snReservationFee = $em->getRepository('AdminMedicalBundle:Company')->calculateReservationFee($asQuoteOfferInfo[0]['company'], $asQuoteOfferInfo[0]['service_price']);
        }
        $asReservationData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getQuoteReservationDetail($snQuoteId, $snCompanyId);
        $html = $this->renderView('ClientMedicalBundle:Communication:finalreservation_mailattachment.html.twig',array(
            'asQuoteOfferInfo'=>$asQuoteOfferInfo,
            'asReservationData'=>$asReservationData,
            'snReservationFee'=>$snReservationFee
        ));
        $dompdf = $this->get('slik_dompdf');
        $dompdf->getpdf($html);
        $pdfoutput = $dompdf->output();
        if(strlen($asReservationData[0]['id']) == 1) {
            $snInvoiceId = '00'.$asReservationData[0]['id'];
        } elseif(strlen($asReservationData[0]['id']) == 2) {
            $snInvoiceId = '0'.$asReservationData[0]['id'];
        } else {
            $snInvoiceId = $asReservationData[0]['id'];
        }
        $snInvoiceNumber = date('Y-m-d').$snInvoiceId;
        $html12 = $this->renderView('ClientMedicalBundle:Communication:second_invoiceattachment.html.twig',array(
            'asQuoteOfferInfo'=>$asQuoteOfferInfo,
            'asReservationData'=>$asReservationData,
            'snInvoiceNumber'=>$snInvoiceNumber,
            'snReservationFee'=>$snReservationFee
        ));
        $dompdf12 = $this->get('slik_dompdf');
        $dompdf12->getpdf($html12);
        $pdfoutput12 = $dompdf12->output();
        return array($pdfoutput, $pdfoutput12);
    }

    public function thankyouAction(){
        return $this->render('ClientMedicalBundle:Communication:thankyou.html.twig');
    }

    public function sendmail($to, $ssBody, $ssSubject, $ssDocumentPath='', $ssFileName='', $ssSecondDocumentPath='', $ssSecondFileName='') {
        $message = \Swift_Message::newInstance()
            ->setContentType("text/html")
            ->setSubject($ssSubject)
            ->setFrom('noreply@medical.lt')
            ->setTo($to)
            ->setBody($ssBody);
        if($ssDocumentPath != '') {
            $message->attach(\Swift_Attachment::newInstance($ssDocumentPath, $ssFileName, 'application/pdf'));
            $message->attach(\Swift_Attachment::newInstance($ssSecondDocumentPath, $ssSecondFileName, 'application/pdf'));
        }
        $this->get('mailer')->send($message);
    }

}