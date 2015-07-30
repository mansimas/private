<?php

namespace Client\MedicalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CronController extends Controller
{
    public function indexAction($name){
        return $this->render('AdminMedicalBundle:Default:index.html.twig', array('name' => $name));
    }

    public function sendmailtousercompanyAction(){
        $em = $this->getDoctrine()->getManager();
        $asTwentyFourFinalReminderdata = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getDetailForSixteenHrsReminder();
        $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('FINAL_REMINDER_AFTER_16_HRS');
        $asData = $oNewMailData->getDescription();
        if(is_array($asTwentyFourFinalReminderdata) && !empty($asTwentyFourFinalReminderdata)) {
            foreach($asTwentyFourFinalReminderdata as $snKey=>$asValue) {
                $snDbDate = $asValue['unconfirmed_twenty_four_or_final_reservation_date'];
                $snDbDate = $snDbDate->format('Y-m-d H:i:s');
                $snSixteenDate = date("Y-m-d H:i:s",strtotime($snDbDate." - 23 hour"));
                $snFinaDate = date("Y-m-d H:i:s",strtotime($snSixteenDate." - 50 minutes"));
                $snTodayDate = date("Y-m-d H:i:s");
                if($snTodayDate > $snFinaDate) {
                    $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField(
                        $asValue['userquotedetails']['id'],
                        $asValue['company']['id'],
                        'Yes',
                        'twenty_four_come_final'
                    );
                    $ssMailContent = str_replace("{FIRSTNAME}",$asValue['userquotedetails']['firstname'],$asData);
                    $ssMailContent = str_replace("{LASTNAME}",$asValue['userquotedetails']['lastname'],$ssMailContent);
                    $ssMailContent = str_replace("{COMPANY_NAME}",$asValue['company']['name'],$ssMailContent);
                    $URL = $this->container->getParameter('site_url').'client/finalreservation/'.$asValue['userquotedetails']['id'].'/'.$asValue['company']['id'];
                    $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                    $ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);
                    $this->sendmail($asValue['userquotedetails']['email'], $ssMailContent, $oNewMailData->getTitle());
                }
            }
        }
        $asUserdata = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getDetailForSentMailByCron('user','No');
        $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('NEW_QUOTE_FROM_CLIENT');
        $asData = $oNewMailData->getDescription();
        if(is_array($asUserdata) && !empty($asUserdata)) {
            foreach($asUserdata as $snKey=>$asValue) {
                $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateTwentyForNoReplyByField($asValue['userquotedetails']['id'], $asValue['company']['id'], 'user', 'Yes', 'twenty_four_no_reply');
                $ssMailContent = str_replace("{FIRSTNAME}",$asValue['userquotedetails']['firstname'],$asData);
                $ssMailContent = str_replace("{LASTNAME}",$asValue['userquotedetails']['lastname'],$ssMailContent);
                $ssMailContent = str_replace("{HEALTH_PROBLEM}",$asValue['userquotedetails']['health_problem'],$ssMailContent);
                $ssMailContent = str_replace("{PREMIUM_LINE}",' ',$ssMailContent);
                $URL = $this->container->getParameter('site_url').'clinic/communications/'.$asValue['userquotedetails']['id'].'/'.$asValue['company']['id'];
                $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                $ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);
                $this->sendmail($asValue['company']['email'], $ssMailContent, $oNewMailData->getTitle());
            }
        }
        $asCompanydata = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getDetailForSentMailByCron('company','No');
        if(is_array($asCompanydata) && !empty($asCompanydata)) {
            foreach($asCompanydata as $snKey=>$asValue) {
                $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateTwentyForNoReplyByField(
                    $asValue['userquotedetails']['id'],
                    $asValue['company']['id'],
                    'company',
                    'Yes',
                    'twenty_four_no_reply'
                );
                $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('NEW_MESSAGE_FROM_CLINIC');
                $asData = $oNewMailData->getDescription();
                $ssMailContent = str_replace("{FIRSTNAME}",$asValue['userquotedetails']['firstname'],$asData);
                $ssMailContent = str_replace("{LASTNAME}",$asValue['userquotedetails']['lastname'],$ssMailContent);
                $ssMailContent = str_replace("{PHONE}",$asValue['userquotedetails']['phone'],$ssMailContent);
                $ssMailContent = str_replace("{EMAIL}",$asValue['userquotedetails']['email'],$ssMailContent);
                $ssMailContent = str_replace("{HEALTH_PROBLEM}",$asValue['userquotedetails']['health_problem'],$ssMailContent);
                $ssMailContent = str_replace("{COMPANY_MESSAGE}",$asValue['reply_message_content'],$ssMailContent);
                $ssMailContent = str_replace("{COMPANY_NAME}",$asValue['company']['name'],$ssMailContent);
                $URL = $this->container->getParameter('site_url').'client/communication/'.$asValue['userquotedetails']['id'].'/'.$asValue['company']['id'];
                $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                $ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);
                $this->sendmail($asValue['userquotedetails']['email'], $ssMailContent, $oNewMailData->getTitle());
            }
        }
        $asUnconfirmedData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getTwentyFourUnconfirmedORFinalReservationDetail('twenty_four');
        if(is_array($asUnconfirmedData) && !empty($asUnconfirmedData)) {
            foreach($asUnconfirmedData as $snKey=>$asValue) {
                $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('REMINDER_ABOUT_UNCONFIRMED_24H_RESERVATION');
                $asData = $oNewMailData->getDescription();
                $ssMailContent = str_replace("{FIRSTNAME}",$asValue['userquotedetails']['firstname'],$asData);
                $ssMailContent = str_replace("{LASTNAME}",$asValue['userquotedetails']['lastname'],$ssMailContent);
                $this->sendmail($asValue['userquotedetails']['email'], $ssMailContent, $oNewMailData->getTitle());
                $asQuoteId[] = $asValue['userquotedetails']['id'];
                $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->updateDataByField($asQuoteId,'quote_status','archive');
                $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField(
                    $asValue['userquotedetails']['id'],
                    $asValue['company']['id'],
                    'archive',
                    'quote_status'
                );
                $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField(
                    $asValue['userquotedetails']['id'],
                    $asValue['company']['id'],
                    'Yes',
                    'sent_unconfirmed_or_rating_mail'
                );
            }
        }
        $asUnconfirmedDatas = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getTwentyFourUnconfirmedORFinalReservationDetail('paid');
        if(is_array($asUnconfirmedDatas) && !empty($asUnconfirmedDatas)) {
            foreach($asUnconfirmedDatas as $snKey=>$asValue) {
                $oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('AFTER_SCHEDULED_APPOINTMENT_REQUEST_TO_GIVE_RATING_FOR_SERVICES');
                $asData = $oNewMailData->getDescription();
                $ssMailContent = str_replace("{FIRSTNAME}",$asValue['userquotedetails']['firstname'],$asData);
                $ssMailContent = str_replace("{LASTNAME}",$asValue['userquotedetails']['lastname'],$ssMailContent);
                $URL = $this->container->getParameter('site_url').'client/addrating/'.$asValue['company']['id'];
                $ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
                $ssMailContent = str_replace("{RATING_URL}",$ssURL,$ssMailContent);
                $ssMailContent = str_replace("{COMPANY_NAME}",$asValue['company']['name'],$ssMailContent);
                $this->sendmail($asValue['userquotedetails']['email'], $ssMailContent, $oNewMailData->getTitle());
                $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField(
                    $asValue['userquotedetails']['id'],
                    $asValue['company']['id'],
                    'Yes',
                    'sent_unconfirmed_or_rating_mail'
                );
            }
        }
        $asNotArchiveQuote = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getActiveOrArchiveQuote('No','archive');
        $asIdQuotes = array();
        if(is_array($asNotArchiveQuote) && !empty($asNotArchiveQuote)) {
            foreach($asNotArchiveQuote as $snKey=>$asValue) {
                $asIdQuotes[] = $asValue['user_quote_id'];
                $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField($asValue['user_quote_id'], $asValue['company_id'], "archive", "quote_status");
            }
            if(count($asIdQuotes) > 0) {
                $snIdQuotes = implode(',',$asIdQuotes);
                $asData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->checkCountOfTotalAndArchiveQuote($snIdQuotes);
                if(is_array($asData) && !empty($asData)) {
                    $asQuoteIds = array();
                    foreach($asData as $snKey=>$asVal) {
                        if($asVal['total_quote'] == $asVal['total_archive_quote']) {
                            $asQuoteIds[] = $asVal['user_quote_detail_id'];
                        }
                    }
                    if(count($asQuoteIds) > 0) {
                        $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->updateDataByField($asQuoteIds,'quote_status','archive');
                    }
                }
            }
            foreach($asNotArchiveQuote as $snKey=>$asValue) {
                $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateReplyType($asValue['user_quote_id'], $asValue['company_id'], "user", "Away");
                $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateReplyType($asValue['user_quote_id'], $asValue['company_id'], "company", "Away");
            }
        }
        exit;
    }

    public function sendmail($to, $ssBody, $ssSubject) {
        $message = \Swift_Message::newInstance()
            ->setContentType("text/html")
            ->setSubject($ssSubject)
            ->setFrom('noreply@medical.com')
            ->setTo($to)
            ->setBody($ssBody);
        $this->get('mailer')->send($message);
    }

}