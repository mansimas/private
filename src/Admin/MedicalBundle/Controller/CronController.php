<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CronController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AdminMedicalBundle:Default:index.html.twig', array('name' => $name));
    }
	
	public function sendmailtouserAction()
    {
		$em = $this->getDoctrine()->getManager();
		$asUserdata = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getDetailForSentMailByCron('user','No');
		
		// send mail to each company which are not replied within 24 Hrs.
		$oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('NEW_QUOTE_FROM_CLIENT');
		$asData = $oNewMailData->getDescription();
		
		foreach($asUserdata as $snKey=>$asValue)
		{
			// Update user_company_quotes table with quote_status "Not replied"
			$em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField($asValue['userquotedetails']['id'], $asValue['company']['id'], 'not_replied', 'quote_status');
			
			$ssQuoteString = '<table "border"=1>
							<tr><td>From </td><td>'.$asValue['userquotedetails']['firstname'].' '.$asValue['lastname']['userquotedetails'].'</td></tr>
							<tr><td>Phone</td><td>'.$asValue['userquotedetails']['phone'].'</td></tr>
							<tr><td>Email</td><td>'.$asValue['userquotedetails']['email'].'</td></tr>
							<tr><td>Health problem</td><td>'.$asValue['userquotedetails']['health_problem'].'</td></tr>
							</table>';
			
			$ssMailContent = str_replace("{QUOTE_INFORMATION}",$ssQuoteString,$asData);
			$URL = $this->container->getParameter('site_url').'clinic/communication/'.$asValue['userquotedetails']['id'];
			$ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
			$ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);
			
			//$ssBody = $this->renderView('AdminMedicalBundle:Quotes:newemail.html.twig', array('name' => $name));
			$this->sendmail($asValue['company']['email'], $ssMailContent, $oNewMailData->getTitle());
		}
    }
	
	public function sendmailtocompanyAction()
    {
		$em = $this->getDoctrine()->getManager();
		$asCompanydata = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getDetailForSentMailByCron('company','No');
		
		foreach($asCompanydata as $snKey=>$asValue)
		{
			$oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('NEW_MESSAGE_FROM_CLINIC');
				$asData = $oNewMailData->getDescription();
				
				$ssQuoteString = '<table "border"=1>
										<tr><td>From </td><td>'.$asValue['userquotedetails']['firstname'].' '.$asValue['userquotedetails']['lastname'].'</td></tr>
										<tr><td>Phone</td><td>'.$asValue['userquotedetails']['phone'].'</td></tr>
										<tr><td>Email</td><td>'.$asValue['userquotedetails']['email'].'</td></tr>
										<tr><td>Health problem</td><td>'.$asValue['userquotedetails']['health_problem'].'</td></tr>
										</table>';
				
				$ssMailContent = str_replace("{QUOTE_INFORMATION}",$ssQuoteString,$asData);
				
				$ssMailContent = str_replace("{COMPANY_MESSAGE}",$asValue['reply_message_content'],$ssMailContent);
				
				$ssMailContent = str_replace("{COMPANY_NAME}",$asValue['company']['name'],$ssMailContent);
				
				$URL = $this->container->getParameter('site_url').'client/communication/'.$asValue['company']['id'].'/'.$asValue['userquotedetails']['id'];
				$ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
				
				$ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);
					
				
				$this->sendmail($asValue['userquotedetails']['email'], $ssMailContent, $oNewMailData->getTitle());
		}				
		
	}
	
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