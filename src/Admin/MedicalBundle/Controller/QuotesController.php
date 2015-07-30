<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\UserQuoteDetail;
use Client\MedicalBundle\Form\QuoteType;
use Client\MedicalBundle\Form\QuoteDocumentsType;
use Admin\MedicalBundle\Entity\UserQuoteDocuments;
use Admin\MedicalBundle\Entity\UserCompanyQuotes;
use Admin\MedicalBundle\Entity\UserCompanyCommunication;
use Admin\MedicalBundle\Form\CompanyListType;
use Admin\MedicalBundle\Form\CommunicationMessageType;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class QuotesController extends Controller
{
	/**
     * function indexAction
     *
     * @param object $request request
     *
     * @todo   Action for display quotes.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();       
        
        $asQuotesData = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->getUserQuoteDetail();     

        return $this->render('AdminMedicalBundle:Quotes:index.html.twig', array('asQuotesData' => $asQuotesData));
    }
	
	/**
     * function addeditAction
     *
     * @param object $request request
     *
     * @todo   Action for add/edit quotes.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function addeditAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$objCoommuMessage = $this->createForm(new CommunicationMessageType());	
		
        $snIdQuotes = $request->get('id');        
		$formImage = $this->createForm(new QuoteDocumentsType());
		$asQuoteCompanyData = array();
		$asQuoteCompanyDocumentsData = array();
		$ssUniqueId = '';
        if(isset($snIdQuotes) && $snIdQuotes != '')
        {
			$em->getRepository('AdminMedicalBundle:UserQuoteDetail')->updateCheckedByAdminField($snIdQuotes);
			
			/* Client-clinic communication detail */
			$asCompanyDetail = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getQuotewiseCompanyDetail($snIdQuotes);
	
			$snCompanyId = $request->get('company_id');

			$asCommunicationDetail = array();
			if(count($asCompanyDetail) > 0 )
			{
				$snCompanyId = (($request->get('company_id') == '') ? $asCompanyDetail[0]['id'] : $request->get('company_id'));
				$asCommunicationDetail = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->getCompanyCommunicationDetail($snIdQuotes, $snCompanyId);
			}
			// It is for company quote's listing
			$asQuoteCompanyData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getCompanyQuotesById($snIdQuotes);
			
			// It is for User document listing.
			$asQuoteCompanyDocumentsData = $em->getRepository('AdminMedicalBundle:UserQuoteDocuments')->getCompanyQuotesDocumentsByQuoteDetailId($snIdQuotes);			
			
			// edit object.
			$objQuotes = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->find($snIdQuotes);
			if($request->isXmlHttpRequest())
			{
				return $this->render('AdminMedicalBundle:Quotes:communication.html.twig', array('asCommunicationDetail' => $asCommunicationDetail,'objQuotes'=>$objQuotes, 'objCoommuMessage'=>$objCoommuMessage,'snQuotesId'=>$snIdQuotes));
			}		
        }
        else
		{
			$objQuotes = new UserQuoteDetail();
		}
        
        $form   = $this->createForm(new QuoteType($this->container), $objQuotes);
        if ($request->isMethod('POST')) 
		{
			$em->persist($objQuotes);                
            $em->flush();
				
            $form->bind($request);            
            if ($form->isValid()) 
            {
				$asQuotesdata['chk_company_id'] = array();
				$asQuotesdata = $request->request->all();
				$asCompanyIds = array();
				if(isset($asQuotesdata['client_medicalbundle_user_quote_detail']['companies']) && count($asQuotesdata['client_medicalbundle_user_quote_detail']['companies']) > 0)
				{
					if(isset($asQuotesdata['chk_company_id']))
					{
						$asCompanyIds = array_merge($asQuotesdata['client_medicalbundle_user_quote_detail']['companies'], $asQuotesdata['chk_company_id']);
						$asCompanyIds = array_unique($asCompanyIds);
					}
					else
					{
						$asCompanyIds = $asQuotesdata['client_medicalbundle_user_quote_detail']['companies'];
					}
				}
				else
				{
					if(isset($asQuotesdata['chk_company_id']))
					{
						$asCompanyIds = $asQuotesdata['chk_company_id'];
					}
				}
				
				if(count($asCompanyIds) > 0)
				{
					
					$asCompanyDetails = $em->getRepository('AdminMedicalBundle:Company')->getOnlyCompanyDetailByIds($asCompanyIds);
					//$oQuote = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->find($snIdQuotes);
					if(count($asCompanyDetails) > 0)
					{
						
						foreach($asCompanyDetails as $snKey=>$asVal)
						{	
							if(isset($asQuotesdata['verify']) && $asQuotesdata['client_medicalbundle_user_quote_detail']['quote_status'] == 'active')
							{
								// send mail to each company with quote detail
								$oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('NEW_QUOTE_FROM_CLIENT');
								$asData = $oNewMailData->getDescription();
								$Quotesdata = $asQuotesdata['client_medicalbundle_user_quote_detail'];
								
								$ssMailContent = str_replace("{FIRSTNAME}",$Quotesdata['firstname'],$asData);
								$ssMailContent = str_replace("{LASTNAME}",$Quotesdata['lastname'],$ssMailContent);								
								$ssMailContent = str_replace("{HEALTH_PROBLEM}",$Quotesdata['health_problem'],$ssMailContent);
					
								$snCountCompany = count($asCompanyDetails) - 1;						
								if($asVal['premium_company'] == 1 && $asVal['disable_quotes'] != 1)
								{
									$ssMailContent = str_replace("{PREMIUM_LINE}","This inquiry was sent to ".$snCountCompany." clinics",$ssMailContent);
								}
								else
								{
									$ssMailContent = str_replace("{PREMIUM_LINE}",' ',$ssMailContent);
								}
								
								$URL = $this->container->getParameter('site_url').'clinic/communications/'.$snIdQuotes.'/'.$asVal['id'];
								$ssURL = '<a href="'.$URL.'">CLICK HERE</a>';
								$ssMailContent = str_replace("{COMMUNICATION_URL}",$ssURL,$ssMailContent);
								
								$DOCURL = $this->container->getParameter('site_url').'uploads/documents/'.$snIdQuotes.'/';
								$this->sendmail($asVal['email'], $ssMailContent, $oNewMailData->getTitle(),$DOCURL,$asQuoteCompanyDocumentsData);
							}
						}
					}	
				}		
				if(isset($asQuotesdata['client_medicalbundle_user_quote_detail']['companies']) && count($asQuotesdata['client_medicalbundle_user_quote_detail']['companies']) > 0)
				{
					$asCompanies = $asQuotesdata['client_medicalbundle_user_quote_detail']['companies'];
					$dbCompanyIds = array();
					foreach($asQuoteCompanyData as $snKey=>$asVal)
					{
						$dbCompanyIds[] = $asVal['company']['id'];
					}
					
					foreach($asCompanies as $snKey=>$ssValue)
					{
						if(!in_array($ssValue, $dbCompanyIds))
						{
							$objCompanyquotes = new UserCompanyQuotes();
							$oCompany = $em->getRepository('AdminMedicalBundle:Company')->findOneById($ssValue);
							
							$objCompanyquotes->setCompany($oCompany);
							$objCompanyquotes->setUserQuoteDetails($objQuotes);
							$em->persist($objCompanyquotes);					
							$em->flush();

							// insert data in user_company_communication when admin approve quote and save data how many company had sent mail.
							$objComm = new UserCompanyCommunication();												
							$objComm->setCompany($oCompany);
							$objComm->setUserquotedetails($objQuotes);
							$objComm->setUserType('user');
							$objComm->setReplyType('No');							
							$em->persist($objComm);         
							$em->flush();
						}						
					}
				}
                $formImage->bind($request);				
				$data = $formImage->getData();				
				$asData = $data->getdocuments();				
				if(isset($asData[0]) && count($asData[0]) > 0)
				{
					$ssFolderPath = $this->container->getParameter('web_path').'documents/';

					if(!is_dir($ssFolderPath))
						mkdir($ssFolderPath, 0777);
					$ssPath = $ssFolderPath.$objQuotes->getId().'/';
					if(!is_dir($ssPath))
						mkdir($ssPath, 0777);
				}
				
				$asDescriptionData = $data->getdescription();				
				foreach($asData as $snKey=>$file)
				{
					if(count($asData[$snKey]) > 0)
					{
						$ssFilename = $file->getClientOriginalName();
						$ssFilename = str_replace(" ","",$ssFilename);
						$ssTempFilePath = $file->getPathName();
						$ssImagePath = $ssPath.$ssFilename;
						move_uploaded_file($ssTempFilePath, $ssImagePath);
					
						$oDocuments = new UserQuoteDocuments();
						$oDocuments->setUserQuoteDetails($objQuotes);						
						$oDocuments->setDocuments($ssFilename);
						$oDocuments->setDescription($asDescriptionData[$snKey]);						
						$em->persist($oDocuments);
					}
                }
                $em->flush();
                $session = $request->getSession();                    
                if(isset($asQuotesdata['verify']) && $asQuotesdata['client_medicalbundle_user_quote_detail']['quote_status'] == 'active')
                    $session->getFlashBag()->add('success', 'Mail Send successfully');
				else
					$session->getFlashBag()->add('success', 'Record updated successfully');
                
				return $this->redirect($this->generateUrl('medical_quotes_addedit',array('id' => $snIdQuotes)));
            }                     
        }		
        return $this->render('AdminMedicalBundle:Quotes:addedit.html.twig', array('form' => $form->createView(), 'formImage'=>$formImage->createView(), 'asQuoteCompanyData'=>$asQuoteCompanyData, 'asQuoteCompanyDocumentsData'=>$asQuoteCompanyDocumentsData, 'objQuotes'=>$objQuotes, 'asCommunicationDetail'=>$asCommunicationDetail, 'asCompanyDetail'=>$asCompanyDetail, 'objCoommuMessage'=>$objCoommuMessage->createView()));
    }
    
	/**
     * function deletequotescompanyAction
     *
     * @param object $request request
     *
     * @todo   Action for delete company's quotes.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function deletequotescompanyAction(Request $request)
    {
        if ($request->isMethod('POST')) 
		{
			$asData = $request->request->all();			
			$asIds = implode(',', $asData['chk_delete']);			
			$session = $request->getSession();
			$em = $this->getDoctrine()->getManager();
			
			$ssFlag = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->deleteData($asIds);
			if($ssFlag)
			{
				$session->getFlashBag()->add('success', 'Record deleted succesfully');
			}			
			return $this->redirect($this->generateUrl('medical_quotes_addedit', array('id' => $request->get('id'))));
		}
	}
	
	/**
     * function deletequotesdocumentAction
     *
     * @param object $request request
     *
     * @todo   Action for delete quote documents.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function deletequotesdocumentAction(Request $request)
    {
		$snId = $request->get('id');
        $snDocumentId = $request->get('doc_id');
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		
		$ssFolderPath = $this->container->getParameter('web_path').'documents/'.$snId.'/';
		
		$oDocuments = $em->getRepository('AdminMedicalBundle:UserQuoteDocuments')->findOneById($snDocumentId);
		if(file_exist($ssFolderPath.'/'.$oDocuments->getDocuments()))
			unlink($ssFolderPath.'/'.$oDocuments->getDocuments());
		$ssFlag = $em->getRepository('AdminMedicalBundle:UserQuoteDocuments')->deleteData($snDocumentId);			
		return $this->redirect($this->generateUrl('medical_quotes_addedit', array('id' => $request->get('id'))));		
	}
	
	/**
     * function communicationmessageaddeditAction
     *
     * @param object $request request
     *
     * @todo   Action for addedit quotes's communication message.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function communicationmessageaddeditAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$objComm = $em->getRepository('AdminMedicalBundle:UserCompanyCommunication')->find($id);
		$snIdQuote = $request->get('quote_id');
		$form = $this->createForm(new CommunicationMessageType(), $objComm);
		if ($request->isMethod('POST')) 
		{
			$form->bind($request);           
            if ($form->isValid()) 
            {    
				$asQuotesdata = $request->request->all();				
				$objComm->setReplyMessageContent($asQuotesdata['clinic_communicationbundle_user_company_communication']['reply_message_content']);
				$objComm->setEditedByAdmin('Yes');
				$em->persist($objComm);                
                $em->flush();
			}			
			return $this->redirect($this->generateUrl('medical_quotes_addedit', array('id' => $snIdQuote)));
		}
	}
	
	/**
     * function sendmail
     *
     * @param string $to                          to mail
	 * @param text   $ssBody                      mail content
	 * @param string $ssSubject                   mail subject
	 * @param string $DOCURL                      URL
	 * @param array  $asQuoteCompanyDocumentsData quotecompany data
     *
     * @todo   Action for delete quote documents.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function sendmail($to, $ssBody, $ssSubject, $DOCURL, $asQuoteCompanyDocumentsData)
	{
		$message = \Swift_Message::newInstance()
			->setContentType("text/html")
			->setSubject($ssSubject)
			->setFrom('noreply@medical.com')
			->setTo($to)
			->setBody($ssBody);	
			if(count($asQuoteCompanyDocumentsData) > 0){
				foreach($asQuoteCompanyDocumentsData as $files)
				{
					$attachment = \Swift_Attachment::fromPath($DOCURL.$files['documents']);
					$message->attach($attachment);					
				}
			}
		$this->get('mailer')->send($message);
	}
	
	/**
     * function downloaddocumentsAction
     *
     * @param object  $request  request
	 * @param integer $id       id
	 * @param string  $filename filename
     *
     * @todo   Action for delete quote documents.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function downloaddocumentsAction(Request $request, $id, $filename)
	{
		$ssDocumentPath = $this->container->getParameter('site_url').'uploads/documents/'.$id.'/'.$filename;
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($ssDocumentPath));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($ssDocumentPath));
		ob_clean();
		flush();
		readfile($ssDocumentPath);
		exit;		
	}
}