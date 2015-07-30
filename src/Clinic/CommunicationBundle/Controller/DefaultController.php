<?php

namespace Clinic\CommunicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\UserCompanyCommunication;

use Clinic\CommunicationBundle\Form\ClinicReplyType;

class DefaultController extends Controller
{
	/**
     * function indexAction
     *
     * @param object  $request  request
	 * @param integer $quote_id quoteid
     *
     * @todo   Action for display communication listing.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction(Request $request, $quote_id)
    {	
		$locale = $this->get('session')->get('_locale');		
		$ssLocale = ((isset($locale) && $locale != '') ? $locale : 'lt');
		
		$oSession = $this->get('security.context')->getToken()->getUser();		
		$em = $this->getDoctrine()->getManager();
		$compnay_id = $request->get('company_id');
		if($compnay_id != '' && $oSession->getId() != $compnay_id)
		{
			return $this->redirect($this->generateUrl('clinic_medical_logout'));
		}
		$asQuoteClientDetail = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getLoggedinCompanywiseQuoteDetail($oSession->getId());
		
		if($quote_id == '' && is_array($asQuoteClientDetail) && !empty($asQuoteClientDetail))
			$quote_id = $asQuoteClientDetail[0]['user_quote_detail_id'];		
		
		$oQuoteDetail = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->findOneById($quote_id);
		
		if(is_object($oQuoteDetail) && ($oQuoteDetail->getQuoteStatus() == 'archive' || $oQuoteDetail->getQuoteStatus() == 'blocked' || $oQuoteDetail->getQuoteStatus() == 'unverified'))
		{
			throw $this->createNotFoundException("Sorry not found.");
		}
		
		$asQuoteStatus = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getCompanyWiseQuoteStatus($quote_id, $oSession->getId());		
		if(is_array($asQuoteStatus) && !empty($asQuoteStatus) && $asQuoteStatus[0]['quote_status'] == 'archive')
		{
			throw $this->createNotFoundException("Sorry not found.");
		}
		
		if($quote_id != '')
		{
			$asCommunicationDetail = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getAllCommunicationDetail($quote_id, $oSession->getId());		
		
			$objComm = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->checkCompanyOffered($quote_id, $oSession->getId());
			if($objComm)
				$form = $this->createForm(new ClinicReplyType(), $objComm);
			else
			{
				$objComm = new UserCompanyCommunication();
				$form = $this->createForm(new ClinicReplyType(), $objComm);
			}	
			$em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateDataByField($quote_id, $oSession->getId(), 'user');
			if($request->isXmlHttpRequest())
			{	
				return $this->render('ClinicCommunicationBundle:Default:communication.html.twig', array('form'=>$form->createView(), 'asCommunicationDetail' => $asCommunicationDetail, 'quote_id'=>$quote_id, 'oQuoteDetail'=>$oQuoteDetail, "objComm"=>$objComm));
			}
			if($request->isMethod('POST')) 
			{				
				$asQuotesdata = $request->request->all();				
				$asQuotesFormdata = $asQuotesdata['clinic_communicationbundle_user_company_communication'];
				if($asQuotesdata['reply'] != "Siųsti pasiūlymą")
				{
					$form->remove('service_price');	
					unset($asQuotesFormdata['service_price']);
				}
				if(isset($asQuotesFormdata['service_price']) && $asQuotesFormdata['service_price'] == '')
				{	
					$session = $request->getSession();
					if(isset($asQuotesFormdata['service_price']) && $asQuotesFormdata['service_price'] == '')
					{
						$translated = $this->get('translator')->trans('Prašome užpildyti');
						$session->getFlashBag()->add('service_price_error', $translated);
					}
				}				
				else
				{					
					$oSession = $this->get('security.context')->getToken()->getUser();					
					$oCompany = $em->getRepository('AdminMedicalBundle:Company')->find($oSession->getId());
					$oQuote = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->find($quote_id);
					if($asQuotesdata['reply'] == "Siųsti pasiūlymą")
					{
						$form->bind($request);
						$objComm->setCompany($oCompany);   
						$objComm->setUserquotedetails($oQuote);
						$objComm->setUserType('company');
						$objComm->setCompanyOffered('Yes');
						$objComm->setCompanyOfferedUnique('Yes');
						
						$oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('CLINIC_OFFERS_SERVICE_PRICE');
						$asData = $oNewMailData->getDescription();
											
						$ssMailContent = str_replace("{FIRSTNAME}",$oQuote->getFirstname(),$asData);
						$ssMailContent = str_replace("{LASTNAME}",$oQuote->getLastname(),$ssMailContent);
						$ssMailContent = str_replace("{COMPANY_NAME}",$oCompany->getName(),$ssMailContent);
						$ssMailContent = str_replace("{SERVICE_DESCRIPTION}",$asQuotesFormdata['service_description'],$ssMailContent);
						$ssMailContent = str_replace("{BRIEF_SERVICE_DESCRIPTION}",$asQuotesFormdata['brief_service_description'],$ssMailContent);
						$ssMailContent = str_replace("{RESPONSIBLE_PERSON}",$asQuotesFormdata['responsible_person_doctor'],$ssMailContent);
						$ssMailContent = str_replace("{SERVICE_PRICE}",$asQuotesFormdata['service_price'],$ssMailContent);
						$ssMailContent = str_replace("{RESERVATION_DATE}",$asQuotesFormdata['reservation_date'],$ssMailContent);
						$ssMailContent = str_replace("{RESERVATION_TIME}",$asQuotesFormdata['reservation_time'],$ssMailContent);
						$ssMailContent = str_replace("{OFFERS_END_DATE}",$asQuotesFormdata['offer_end_date'],$ssMailContent);
					
						$URL = $this->container->getParameter('site_url').'client/communication/'.$quote_id.'/'.$oSession->getId();
						$ssURL = '<a href="'.$URL.'">CLICK HERE</a>';					
						$ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);					
						$this->sendmail($oQuote->getEmail(), $ssMailContent, $oNewMailData->getTitle());					
					}
					else
					{
						$objComm = new UserCompanyCommunication();
						$objComm->setCompany($oCompany);   
						$objComm->setUserquotedetails($oQuote);
						$objComm->setUserType('company');
						$objComm->setReplyMessageContent($asQuotesFormdata['reply_message_content']);
						$oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('NEW_MESSAGE_FROM_CLINIC');
						$asData = $oNewMailData->getDescription();						
						$ssMailContent = str_replace("{FIRSTNAME}",$oQuote->getFirstname(),$asData);
						$ssMailContent = str_replace("{LASTNAME}",$oQuote->getLastname(),$ssMailContent);				
						$ssMailContent = str_replace("{PHONE}",$oQuote->getPhone(),$ssMailContent);					
						$ssMailContent = str_replace("{EMAIL}",$oQuote->getEmail(),$ssMailContent);					
						$ssMailContent = str_replace("{HEALTH_PROBLEM}",$oQuote->getHealthProblem(),$ssMailContent);						
						$ssMailContent = str_replace("{COMPANY_MESSAGE}",$asQuotesdata['clinic_communicationbundle_user_company_communication']['reply_message_content'],$ssMailContent);					
						$ssMailContent = str_replace("{COMPANY_NAME}",$oSession->getName(),$ssMailContent);					
						$URL = $this->container->getParameter('site_url').'client/communication/'.$quote_id.'/'.$oSession->getId();
						$ssURL = '<a href="'.$URL.'">CLICK HERE</a>';						
						$ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);					
						$this->sendmail($oQuote->getEmail(), $ssMailContent, $oNewMailData->getTitle());				
						$objComm->setCompanyOffered('No');
					}
					$objComm->setCheckedByClient('No');
					$objComm->setReplyType('No');
					$em->persist($objComm);                
					$em->flush();
					/* Update reply_type Yes Of type user for this company */
					$em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->updateReplyType($quote_id, $oSession->getId(),'user');
					// Update user_company_quotes table with quote_status "In progress"
					$em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField($quote_id, $oSession->getId(), 'in_progress', 'quote_status');				
					return $this->redirect($this->generateUrl('clinic_communication_homepage', array('quote_id' => $quote_id)));				
				}
			}
			return $this->render('ClinicCommunicationBundle:Default:index.html.twig', array('form'=>$form->createView(), 'asCommunicationDetail'=>$asCommunicationDetail, 'quote_id'=>$quote_id,'oQuoteDetail'=>$oQuoteDetail,'asQuoteClientDetail'=>$asQuoteClientDetail, "objComm"=>$objComm));
		}
		else
		{
			return $this->render('ClinicCommunicationBundle:Default:index.html.twig', array('asQuoteClientDetail'=>array(), 'asCommunicationDetail'=>array(), 'quote_id'=>$quote_id));
		}
    }
	
	/**
     * function clinicreplyAction
     *
     * @param object  $request  request	 
     *
     * @todo   Action for replying clinic.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function testAction(Request $request, $quote_id)
    {		
		$request = $this->getRequest();
		$oSession = $this->get('security.context')->getToken()->getUser();			
		if($oSession->getId() == '')
		{	
			$session = $request->getSession();
			$session->set('quote_id', $quote_id);
			return $this->redirect($this->generateUrl('clinic_medical_login'));
		}
		else
		{			
			return $this->redirect($this->generateUrl('clinic_communication_homepage', array('quote_id'=>$quote_id)));
		}
    }
	
	/**
     * function clinicreplyAction
     *
     * @param object  $request  request	 
     *
     * @todo   Action for replying clinic.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function logintempAction(Request $request)
    {
		$request = $this->getRequest();
		$session = $request->getSession();
		$snIdQuote = $session->get('quote_id');
		if($snIdQuote != '')
			return $this->redirect($this->generateUrl('clinic_communication_homepage', array('quote_id' => $snIdQuote)));
		else
			return $this->redirect($this->generateUrl('clinic_communication_homepage'));
	}
	
	/**
     * function sendmail
     *
     * @param  string  $to  	  toemail	 
	 * @param  string  $ssBody    mailcontent
	 * @param  string  $ssSubject subject
     *
     * @todo   Function for sending mail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function sendmail($to, $ssBody, $ssSubject)
	{
		$message = \Swift_Message::newInstance()
			->setContentType("text/html")
			->setSubject($ssSubject)
			->setFrom('noreply@medical.com')
			->setTo($to)
			->setBody($ssBody);
		
		$this->get('mailer')->send($message);		
	}
}