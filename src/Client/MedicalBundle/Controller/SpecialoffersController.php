<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Client\MedicalBundle\Extension\WebToPay;
use Client\MedicalBundle\Form\SpecialOfferSalesType;
use Admin\MedicalBundle\Entity\SpecialofferSales;
use Admin\MedicalBundle\Entity\SpecialCouponCodes;

class SpecialoffersController extends Controller
{
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($request->isXmlHttpRequest()) {
            $em->getRepository('AdminMedicalBundle:SpecialOffers')->updatespecialofferwithexpire();
            return $this->render('ClientMedicalBundle:Specialoffers:allspecialoffers.html.twig', array(
                'asSpecialOffersData'=>$asSpecialOffersData,
                'ssRoute'=>'client_medical_special_offers'
            ));
        } else {
            return $this->render('ClientMedicalBundle:Specialoffers:index.html.twig', array(
                'asSpecialOffersData'=>$asSpecialOffersData,
                'ssRoute'=>'client_medical_special_offers',
                'asMetaData'=>$asMetaData
            ));
        }
    }

    public function specialofferdetailAction(Request $request, $id) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale, $id);
        $asRandomSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale,'',true);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if($request->isXmlHttpRequest()) {
            if($request->get('specialoffer_type')) {
                $em->getRepository('AdminMedicalBundle:SpecialOffers')->updatespecialofferwithexpire();
                return $this->render('ClientMedicalBundle:Specialoffers:mainspecialofferdetail.html.twig', array(
                    'asSpecialOffersData'=>$asSpecialOffersData,
                    'asRandomSpecialOffersData'=>$asRandomSpecialOffersData,
                    'ssRoute'=>'client_medical_special_offers_detail',
                    'snCompanyId'=>$id
                ));
            }
            return $this->render('ClientMedicalBundle:Specialoffers:footerspecialoffer.html.twig', array(
                'asSpecialOffersData'=>$asSpecialOffersData,
                'asRandomSpecialOffersData'=>$asRandomSpecialOffersData,
                'ssRoute'=>'client_medical_special_offers_detail',
                'snCompanyId'=>$id
            ));
        } else {
            return $this->render('ClientMedicalBundle:Specialoffers:specialofferdetail.html.twig', array(
                'asSpecialOffersData'=>$asSpecialOffersData,
                'asRandomSpecialOffersData'=>$asRandomSpecialOffersData,
                'ssRoute'=>'client_medical_special_offers_detail',
                'asMetaData'=>$asMetaData
            ));
        }
    }

    public function buyspecialofferAction(Request $request, $id) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $entity = new SpecialofferSales();
        $form = $this->createForm(new SpecialOfferSalesType(), $entity);
        $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferRandomDetail($ssLocale, $id);
        $asMetaData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('WEBSITE_META_SETTINGS', $ssLocale);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $oSpecialObj = $em->getRepository('AdminMedicalBundle:SpecialOffers')->find($id);
                $entity->setSpecialoffers($oSpecialObj);
                $em->persist($entity);
                $em->flush();
                $asSaledatas = $request->request->all();
                $asSaledata = $asSaledatas['client_medicalbundle_specialoffer_sales'];
                $oSpecialSaleObj = $em->getRepository('AdminMedicalBundle:SpecialofferSales')->find($entity->getId());
                $snCount = $asSaledata['number_of_coupon'];
                for($i=1; $i <= $snCount; $i++) {
                    $oCouponCode = new SpecialCouponCodes();
                    $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'. '0123456789');
                    shuffle($seed);
                    $rand = '';
                    foreach (array_rand($seed, 10) as $k) {
                        $rand .= $seed[$k];
                    }
                    $snUniqueCode = $rand;
                    $oCouponCode->setUniqueCode($snUniqueCode);
                    $oCouponCode->setSpecialsale($oSpecialSaleObj);
                    $oCouponCode->setSpecialoffers($oSpecialObj);
                    $em->persist($oCouponCode);
                    $em->flush();
                }
                return $this->redirect($this->generateUrl('client_specialoffer_payment', array(
                    'offer_id'=>$id,
                    'offer_sales_price'=>$asSaledatas['final_total_coupon_price'],
                    'sale_id'=>$entity->getId()
                )));
            }
        }
        return $this->render('ClientMedicalBundle:Specialoffers:buyspecialoffer.html.twig', array(
            'asSpecialOffersData'=>$asSpecialOffersData,
            'form'=>$form->createView(),
            'asMetaData'=>$asMetaData
        ));
    }

    public function paymentAction() {
        echo ""; exit;
    }

    public function cancelAction(Request $request) {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $sale_id = $request->get('id');
        if($sale_id != 0 || $sale_id != '') {
            $oSaleDetail = $em->getRepository('AdminMedicalBundle:SpecialofferSales')->find($sale_id);
            $id = $oSaleDetail->getSpecialoffers()->getId();
            $translated = $this->get('translator')->trans('Your payment is cancel!');
            $session->getFlashBag()->add('error', $translated);
            return $this->redirect($this->generateUrl('client_medical_buy_special_offers',array('id'=>$id)));
        } else {
            return $this->redirect($this->generateUrl('client_medical_homepage'));
        }
    }

    public function callbackAction() {
        try {
            echo 'OK';
        }
        catch (Exception $e)
        {
            echo get_class($e) . ': ' . $e->getMessage();
        }
    }

    public function buysuccessAction(Request $request) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $params = array();
        parse_str(base64_decode(strtr($_GET['data'], array('-' => '+', '_' => '/'))), $params);
        $em = $this->getDoctrine()->getManager();
        $snTransactionId = $params['requestid'];
        $ssPaymentStatus = $params['status'];
        $sale_id = $params['orderid'];
        $oSaleDetail = $em->getRepository('AdminMedicalBundle:SpecialofferSales')->find($sale_id);
        $email = $oSaleDetail->getEmail();
        $name = $oSaleDetail->getName();
        $phone = $oSaleDetail->getPhone();
        $coupon = $oSaleDetail->getNumberOfCoupon();
        $id = $oSaleDetail->getSpecialoffers()->getId();
        $session = $request->getSession();
        if($ssPaymentStatus == 1 || $ssPaymentStatus == 2) {
            $ssPaymentStatus = 1;
            $oSpecialObj = $em->getRepository('AdminMedicalBundle:SpecialOffers')->find($id);
            $oSpecialObj->setSaleDate(new \DateTime());
            $oSpecialObj->setCheckedByAdmin("No");
            $em->persist($oSpecialObj);
            $em->flush();
            $em->getRepository('AdminMedicalBundle:SpecialofferSales')->updateData($sale_id, $snTransactionId, $ssPaymentStatus);
            $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('SPECIAL_OFFER_CONFIRMATION_AFTER_CHECKOUT');
            $asData = $oNewMailData->getDescription();
            $asSpecialOfferData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getAllSpecialOfferDetailById($id,$ssLocale);
            $ssMailContent = str_replace("{SPECIAL_OFFER_TITLE}",$asSpecialOfferData[0]['translations'][2]['content'],$asData);
            $ssMailContent = str_replace("{SPECIAL_OFFER_INTRODUCTION}",$asSpecialOfferData[0]['translations'][1]['content'],$ssMailContent);
            $ssMailContent = str_replace("{SPECIAL_OFFER_PRICE}",$asSpecialOfferData[0]['sales_price'],$ssMailContent);
            $asSpecialCouponCodeData = $em->getRepository('AdminMedicalBundle:SpecialCouponCodes')->getAllSpecialOfferCouponCodes($sale_id);
            $this->sendmail(
                $email,
                $ssMailContent,
                $oNewMailData->getTitle(),
                $asSpecialOfferData,
                $asSpecialCouponCodeData,
                $name,
                $sale_id,
                $email,
                $phone,
                $coupon
            );
            $translated = $this->get('translator')->trans('Your payment done successfully');
            $session->getFlashBag()->add('success', $translated);
            return $this->redirect($this->generateUrl('client_medical_sendquotesuccess'));
        } else {
            $translated = $this->get('translator')->trans('Your payment is failed, try again!');
            $session->getFlashBag()->add('error', $translated);
            return $this->redirect($this->generateUrl('client_medical_buy_special_offers',array('id'=>$id)));
        }
    }

    public function sendmail($to, $ssBody, $ssSubject, $asSpecialOfferData, $asSpecialCouponCodeData, $name, $sale_id, $email, $phone, $coupon) {
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject($ssSubject)
            ->setFrom($this->container->getParameter('noreply_mail'))
            ->setTo($to)
            ->setBcc($this->container->getParameter('bcc_mail'))
            ->setBody($ssBody);
            foreach($asSpecialCouponCodeData as $snKey=>$asVal) {
                $ssDocumentPath = $this->generatePDFForSpecialOffer($asSpecialOfferData, $name, $asVal['unique_code']);
                $ssFileName = $asVal['unique_code'].'.pdf';
                $message->attach(\Swift_Attachment::newInstance($ssDocumentPath, $ssFileName, 'application/pdf'));
            }
            $ssSecondDocumentPath = $this->generatePDFForInvoiceSpecialOffer($asSpecialOfferData, $sale_id, $name, $email, $phone, $coupon);
            $ssSecondInvoceFileName = 'invoice.pdf';
            $message->attach(\Swift_Attachment::newInstance($ssSecondDocumentPath, $ssSecondInvoceFileName, 'application/pdf'));
            $this->get('mailer')->send($message);
    }

    public function generatePDFForSpecialOffer($asSpecialOfferData, $name, $snUniqueCode) {
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        $asConditionData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getDetailByArticleType('COUPON_CONDITIONS', $ssLocale);
        $html = $this->renderView('ClientMedicalBundle:Specialoffers:buyspecialoffer_mailattachment.html.twig',array('asSpecialOfferData'=>$asSpecialOfferData, 'name'=>$name,'coupon_code'=>$snUniqueCode,'asConditionData'=>$asConditionData));
        $dompdf = $this->get('slik_dompdf');
        $dompdf->getpdf($html);
        return $pdfoutput = $dompdf->output();
    }

    public function generatePDFForInvoiceSpecialOffer($asSpecialOfferData, $snSaleId, $name, $email, $phone, $coupon) {
        if(strlen($snSaleId) == 1) {
            $snInvoiceId = '00'.$snSaleId;
        } elseif(strlen($snSaleId) == 2) {
            $snInvoiceId = '0'.$snSaleId;
        } else {
            $snInvoiceId = $snSaleId;
        }
        $snInvoiceNumber = date('Y-m-d').$snInvoiceId;
        $html12 = $this->renderView('ClientMedicalBundle:Specialoffers:second_invoiceattachment.html.twig',array(
            'coupon'=>$coupon,
            'email'=>$email,
            'phone'=>$phone,
            'name'=>$name,
            'asSpecialOfferData'=>$asSpecialOfferData,
            'snInvoiceNumber'=>$snInvoiceNumber
        ));
        $dompdf12 = $this->get('slik_dompdf');
        $dompdf12->getpdf($html12);

        return $pdfoutput12 = $dompdf12->output();
    }
}