<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\EmailTemplates;
use Admin\MedicalBundle\Form\EmailTemplatesType;

use Admin\MedicalBundle\Entity\StaticArticles;
use Admin\MedicalBundle\Form\StaticArticlesType;

use Admin\MedicalBundle\Entity\Languages;
use Admin\MedicalBundle\Form\LanguagesType;

use Admin\MedicalBundle\Entity\PaymentOption;
use Admin\MedicalBundle\Form\PaymentOptionType;

use Admin\MedicalBundle\Entity\City;
use Admin\MedicalBundle\Form\CityType;

use Admin\MedicalBundle\Entity\Admin;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\RedirectResponse;

class SettingsController extends Controller
{
	/**
     * function emailtemplatesAction
     *	 
     *
     * @todo   Action for display email templates.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function emailtemplatesAction()
    {
        $em = $this->getDoctrine()->getManager();       
        $asEmailsTemplate = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findAll();		
        return $this->render('AdminMedicalBundle:Settings:emailtemplates.html.twig', array('asEmailsTemplate' => $asEmailsTemplate));
    }
	
	/**
     * function emailaddeditAction
     *
     * @param object  $request    request	 	 
     *
     * @todo   Action for email template add/edit.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function emailaddeditAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager(); 
		$snIdEmailTemplates = $request->get('id');
		if(isset($snIdEmailTemplates) && $snIdEmailTemplates != '')
        {
            $objEmail = $em->getRepository('AdminMedicalBundle:EmailTemplates')->find($snIdEmailTemplates);            
        }
		else
			$objEmail = new EmailTemplates();
		
        $form   = $this->createForm(new EmailTemplatesType(), $objEmail);
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
				$em->persist($objEmail);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdEmailTemplates) && $snIdEmailTemplates != '')
                    $session->getFlashBag()->add('success', 'Record updated succesfully');
                else
                    $session->getFlashBag()->add('success', 'Record added succesfully');
                return $this->redirect($this->generateUrl('medical_settings_emails'));
			}
		}
		return $this->render('AdminMedicalBundle:Settings:emailaddedit.html.twig', array('form' => $form->createView()));
	}
	
	/**
     * function articlesAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for display articles.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function articlesAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();       
        
        $asArticlesData = $em->getRepository('AdminMedicalBundle:StaticArticles')->getAllArticlesDetail();
        
        return $this->render('AdminMedicalBundle:Settings:articles.html.twig', array('asArticlesData' => $asArticlesData));
	}
	
	/**
     * function articlesaddeditAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for articles add/edit.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function articlesaddeditAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
        $snIdArticle = $request->get('id');        
        if(isset($snIdArticle) && $snIdArticle != '')
        {
            $objArticle = $em->getRepository('AdminMedicalBundle:StaticArticles')->find($snIdArticle);            
        }
        else 
		{
			$objArticle = new StaticArticles();
		}        
        $form   = $this->createForm(new StaticArticlesType($this->container), $objArticle);
        if($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
                $em->persist($objArticle);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdArticle) && $snIdArticle != '')
                    $session->getFlashBag()->add('success', 'Record updated succesfully');
                else
                    $session->getFlashBag()->add('success', 'Record added succesfully');
                return $this->redirect($this->generateUrl('medical_settings_articles'));
            }                     
        }
        return $this->render('AdminMedicalBundle:Settings:articlesaddedit.html.twig', array('form' => $form->createView()));		
	}
	
	/**
     * function deleteAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for delete static articles.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function deleteAction(Request $request)
    {
        if ($request->isMethod('POST')) 
		{
			$asData = $request->request->all();			
			$asIds = implode(',', $asData['chk_delete']);
			
			$session = $request->getSession();
			$em = $this->getDoctrine()->getManager();
			
			if(isset($asData['publish']) && $asData['publish'] == 'Publish')
			{
				$ssStatus = "Published";
				$ssFlag = $em->getRepository('AdminMedicalBundle:StaticArticles')->updateData($asIds, $ssStatus);
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record published succesfully');
				}
			}			
			elseif(isset($asData['unpublish']) && $asData['unpublish'] == 'Unpublish')
			{
				$ssStatus = "Unpublished";
				$ssFlag = $em->getRepository('AdminMedicalBundle:StaticArticles')->updateData($asIds, $ssStatus);
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record unpublished succesfully');
				}
			}
			elseif(isset($asData['delete']) && $asData['delete'] == 'Delete')
			{
				$ssFlag = $em->getRepository('AdminMedicalBundle:StaticArticles')->deleteData($asIds);
				
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record deleted succesfully');
				}
			}
			return $this->redirect($this->generateUrl('medical_settings_articles'));
		}
	}
	
	/**
     * function deletelanguageAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for delete langauge.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function deletelanguageAction(Request $request)
    {
		if($request->isMethod('POST')) 
		{
			$asData = $request->request->all();			
			$asIds = $request->get('id');
			
			$em = $this->getDoctrine()->getManager();
			$ssFlag = $em->getRepository('AdminMedicalBundle:Languages')->deleteData($asIds);
			if($ssFlag)
			{
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'Record deleted succesfully');
			}
			return $this->redirect($this->generateUrl('medical_settings_languages'));
		}
	}
	
	/**
     * function languagesAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for display languages.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function languagesAction(Request $request)
	{
		$objLang = new Languages();
		$form   = $this->createForm(new LanguagesType(), $objLang);
		
		$em = $this->getDoctrine()->getManager();
        $asLanguagesData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();        
        return $this->render('AdminMedicalBundle:Settings:languages.html.twig', array('asLanguagesData' => $asLanguagesData, 'form' => $form->createView()));
	}
	
	/**
     * function languagesaddeditAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for languages add/edit.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function languagesaddeditAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
        $snIdLanguage = $request->get('id');		
        if(isset($snIdLanguage) && $snIdLanguage != '')
        {
            $objLang = $em->getRepository('AdminMedicalBundle:Languages')->find($snIdLanguage);
			$ssDbFileName = $objLang->getFlag();
        }
        else
		{			
			$objLang = new Languages();
		}
        $form   = $this->createForm(new LanguagesType(), $objLang);		
		if($request->isMethod('POST')) 
		{			
			$form->bind($request);			
            if($form->isValid()) 
            {            
				$asData = $_FILES["flagUpload"];				
                if(is_array($asData) && $asData['name'] != '')
                {	
                    $ssFolderPath = $this->container->getParameter('web_path').'flag/';					
                    if(!is_dir($ssFolderPath))
                        mkdir($ssFolderPath, 0777);

					$ssFilename = $asData['name'];
                    $asFilesData = explode('.', $ssFilename);

                    $ssOriginalFileName = uniqid().'.'.$asFilesData[1];
                    $ssTempFilePath = $asData['tmp_name'];

                    $ssImagePath = $ssFolderPath.$ssOriginalFileName;
                    move_uploaded_file($ssTempFilePath, $ssImagePath);

                    if(isset($snIdLanguage) && $snIdLanguage != '')
                    {
						$objLang =  $objLang->setFlag($ssOriginalFileName);
						$ssNewFileName = $objLang->getFlag();
						$ssOldFilePath = $ssFolderPath.$ssDbFileName;
						/* delete old file*/
                        if(isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath))
						{
							unlink($ssOldFilePath);
						}
                    }
                    else						
                       $objLang->setFlag($ssOriginalFileName);
                }				
				$asLang = $_POST["name"];
				$asCode = $_POST["code"];
				
				if($asData['name'] == '' && $snIdLanguage != '')
				{
					$objLang->setFlag($ssDbFileName);
				}
				if(isset($asLang) && $asLang !='')
				{
					$objLang->setName($asLang);
				}
				if(isset($asCode) && $asCode !='')
				{
					$objLang->setCode($asCode);
				}
                $em->persist($objLang);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdLanguage) && $snIdLanguage != '')
                    $session->getFlashBag()->add('success', 'Record updated succesfully');
                else
                    $session->getFlashBag()->add('success', 'Record added succesfully');
                return $this->redirect($this->generateUrl('medical_settings_languages'));
            }
			return $this->redirect($this->generateUrl('medical_settings_languages'));
		}
		
		$em = $this->getDoctrine()->getManager();
        $snIdLanguage = $request->get('id');
		
        if(isset($snIdLanguage) && $snIdLanguage != '')
        {
			$objLang = $em->getRepository('AdminMedicalBundle:Languages')->find($snIdLanguage);            			
        }
        else
		{
			$objLang = new Languages();
		}
        
        $form = $this->createForm(new LanguagesType(), $objLang);		
        if($request->isMethod('POST')) 
		{
			$form->bind($request);
            if ($form->isValid()) 
            {
				// Flag Upload Code
				$asData = $request->files->get('admin_medicalbundle_languages');                
                if(is_array($asData) && $asData['flag'] != '')
                {
                    $ssFolderPath = $this->container->getParameter('web_path').'flag/';

                    if(!is_dir($ssFolderPath))
                        mkdir($ssFolderPath, 0777);

                    $ssFilename = $asData['flag']->getClientOriginalName();
                    $asFilesData = explode('.', $ssFilename);                

                    $ssOriginalFileName = uniqid().'.'.$asFilesData[1];
                    $ssTempFilePath = $asData['flag']->getPathName();

                    $ssImagePath = $ssFolderPath.$ssOriginalFileName;
                    move_uploaded_file($ssTempFilePath, $ssImagePath);

                    if(isset($snIdLanguage) && $snIdLanguage != '')
                    {
                       $objLang =  $objLang->setFlag($ssOriginalFileName);
                       $ssNewFileName = $objLang->getFlag();
                       $ssOldFilePath = $ssFolderPath.$ssDbFileName;
                       /* delete old file*/
                       if(isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath))
                       {
                           unlink($ssOldFilePath);
                       }
                    }
                    else                    
                       $objLang->setFlag($ssOriginalFileName); 
                }
				//End Flag code
                $em->persist($objLang);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdLanguage) && $snIdLanguage != '')
                    $session->getFlashBag()->add('success', 'Record updated succesfully');
                else
                    $session->getFlashBag()->add('success', 'Record added succesfully');
                return $this->redirect($this->generateUrl('medical_settings_languages'));
            }                     
        }
        return $this->render('AdminMedicalBundle:Settings:addedit.html.twig', array('form' => $form->createView()));	
	}
	
	/**
     * function usermanagerAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for display user management.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function usermanagerAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();       
        $asAdminData = $em->getRepository('AdminMedicalBundle:Admin')->findAll();
        return $this->render('AdminMedicalBundle:Settings:usermanager.html.twig', array('asAdminData' => $asAdminData));
	}
	
	/**
     * function usermanageraddeditAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for usr add/edit.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function usermanageraddeditAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
        $snIdAdmin = $request->get('id');		
        if(isset($snIdAdmin) && $snIdAdmin != '')
        {
            $objAdmin = $em->getRepository('AdminMedicalBundle:Admin')->find($snIdAdmin);
        }
        else
		{			
			$objAdmin = new Admin();
		}
	
		if ($request->isMethod('POST')) 
		{
			$asName = $_POST["name"];
			$asLogin = $_POST["login"];
			$asEmail = $_POST["email"];
			$asPassword = $_POST["password"];
			$asRepPassword = $_POST["rpt_password"];
			$asUserType = $_POST["user_type"];
			
			if(isset($asName) && $asName !='')
			{
				$objAdmin->setName($asName);
			}
			if(isset($asLogin) && $asLogin !='')
			{
				$objAdmin->setLogin($asLogin);
			}
			if(isset($asEmail) && $asEmail !='')
			{
				$objAdmin->setEmail($asEmail);
			}
			if(isset($asPassword) && $asPassword !='')
			{
				$objAdmin->setPassword($asPassword);
			}
			if(isset($asUserType) && $asUserType !='')
			{
				$objAdmin->setUserType($asUserType);
			}
			$session = $request->getSession();
			if($asPassword != $asRepPassword)
			{
				$session->getFlashBag()->add('success', 'Password And Repeat Password Must be Same');
				return $this->redirect($this->generateUrl('medical_settings_usermanager'));
			}
			$em->persist($objAdmin);                
			$em->flush();               
			
			if(isset($snIdAdmin) && $snIdAdmin != '')
				$session->getFlashBag()->add('success', 'Record updated succesfully');
			else
				$session->getFlashBag()->add('success', 'Record added succesfully');
			return $this->redirect($this->generateUrl('medical_settings_usermanager'));
		}
	}
	
	/**
     * function deleteusermanagerAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for delete user.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function deleteusermanagerAction(Request $request)
    {
        if ($request->isMethod('POST')) 
		{
			$asData = $request->request->all();			
			$asIds = $request->get('id');
			$em = $this->getDoctrine()->getManager();
			$ssAdmin = $em->getRepository('AdminMedicalBundle:Admin')->find($asIds);
			$em->remove($ssAdmin);                
			$em->flush(); 
			$session = $request->getSession();
			$session->getFlashBag()->add('success', 'Record deleted succesfully');
			echo "success";
			exit;
		}
	}
	
	/**
     * function alllanguagesAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for display all languages.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function alllanguagesAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
		$asAllLanguagesData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();

		return $this->render('AdminMedicalBundle:Settings:alllanguages.html.twig', array('asAllLanguagesData' => $asAllLanguagesData));
	}
	
	/**
     * function paymentoptionAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for display paymentoption.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function paymentoptionAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
		$asPaymentData = $em->getRepository('AdminMedicalBundle:PaymentOption')->findAll();
		
        return $this->render('AdminMedicalBundle:Settings:paymentoption.html.twig', array('asPaymentData' => $asPaymentData));
	}
	
	/**
     * function paymentoptiondeleteAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for delete paymentoption.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function paymentoptiondeleteAction(Request $request) 
	{
		if ($request->isMethod('POST')) 
		{
			$asData = $request->request->all();			
			$asIds = implode(',', $asData['chk_delete']);
			$session = $request->getSession();
			$em = $this->getDoctrine()->getManager();			
			if(isset($asData['delete']) && $asData['delete'] == 'Delete')
			{
				$ssFlag = $em->getRepository('AdminMedicalBundle:PaymentOption')->deleteData($asIds);
				$session->getFlashBag()->add('success', 'Record deleted successfully');				
			}
			return $this->redirect($this->generateUrl('medical_settings_paymentoption'));			
		}
	}
	
	/**
     * function addeditpaymentoptionAction
     *
     * @param  object  $request    request	 
     *
     * @todo   Action for paymentoption add/edit.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function addeditpaymentoptionAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
        $snIdPaymentOption = $request->get('id');        
        if(isset($snIdPaymentOption) && $snIdPaymentOption != '')
        {
            $objPayment = $em->getRepository('AdminMedicalBundle:PaymentOption')->find($snIdPaymentOption);            
        }
        else
		{
			$objPayment = new PaymentOption();
		}        
        $form   = $this->createForm(new PaymentOptionType($this->container), $objPayment);
        if($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
				$asData = $request->files->get('admin_medicalbundle_payment');                
                if(is_array($asData) && $asData['photo'] != '')
                {
                    $ssFolderPath = $this->container->getParameter('web_path').'payment_option/';

                    if(!is_dir($ssFolderPath))
                        mkdir($ssFolderPath, 0777);

                    $ssFilename = $asData['photo']->getClientOriginalName();
                    $asFilesData = explode('.', $ssFilename);                

                    $ssOriginalFileName = uniqid().'.'.$asFilesData[1];
                    $ssTempFilePath = $asData['photo']->getPathName();

                    $ssImagePath = $ssFolderPath.$ssOriginalFileName;
                    move_uploaded_file($ssTempFilePath, $ssImagePath);
					
					if(isset($snIdNews) && $snIdNews != '')
                    {
                       $objPayment =  $objPayment->setPhoto($ssOriginalFileName);
                       $ssNewFileName = $objPayment->getPhoto();
                       $ssOldFilePath = $ssFolderPath.$ssDbFileName;
                       /* delete old file*/
                       if(isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath))
                       {
                           unlink($ssOldFilePath);
                       }
                    }
                    else                    
                       $objPayment->setPhoto($ssOriginalFileName); 
				}
                $em->persist($objPayment);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdPaymentOption) && $snIdPaymentOption != '')
                    $session->getFlashBag()->add('success', 'Record updated successfully');
                else
                    $session->getFlashBag()->add('success', 'Record added successfully');
                return $this->redirect($this->generateUrl('medical_settings_paymentoption'));
            }                     
        }	
        return $this->render('AdminMedicalBundle:Settings:addeditpaymentoption.html.twig', array('form' => $form->createView(), 'objPayment'=>$objPayment));
	}
	
	/**
     * function cityAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for display cities.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function cityAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
		$asCityData = $em->getRepository('AdminMedicalBundle:City')->findAll();
		
        return $this->render('AdminMedicalBundle:Settings:city.html.twig', array('asCityData' => $asCityData));
	}
	
	/**
     * function citydeleteAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for delete city.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function citydeleteAction(Request $request) 
	{
		if ($request->isMethod('POST')) 
		{
			$asData = $request->request->all();			
			$asIds = implode(',', $asData['chk_delete']);
			
			$session = $request->getSession();
			$em = $this->getDoctrine()->getManager();
			
			if(isset($asData['delete']) && $asData['delete'] == 'Delete')
			{
				$ssFlag = $em->getRepository('AdminMedicalBundle:City')->deleteData($asIds);
				$session->getFlashBag()->add('success', 'Record deleted successfully');				
			}
			return $this->redirect($this->generateUrl('medical_settings_city'));			
		}
	}
	
	/**
     * function addeditcityAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for city add/edit.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function addeditcityAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
        $snIdCity = $request->get('id');        
        if(isset($snIdCity) && $snIdCity != '')
        {
            $objCity = $em->getRepository('AdminMedicalBundle:City')->find($snIdCity);            
        }
        else 
		{
			$objCity = new City();
		}        
        $form   = $this->createForm(new CityType($this->container), $objCity);
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
				$asData = $request->files->get('admin_medicalbundle_city');
                $em->persist($objCity);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdCity) && $snIdCity != '')
                    $session->getFlashBag()->add('success', 'Record updated successfully');
                else
                    $session->getFlashBag()->add('success', 'Record added successfully');
                return $this->redirect($this->generateUrl('medical_settings_city'));
            }                     
        }	
        return $this->render('AdminMedicalBundle:Settings:addeditcity.html.twig', array('form' => $form->createView()));
	}
	
	/**
     * function formAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for display selected specialoffer detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function formAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
		$asLanguagesData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
        if(is_array($asLanguagesData) && empty($asLanguagesData))
			$asLocalesData = $this->container->getParameter('default_locales');		
		else
			$asLocalesData = array();
        return $this->render('AdminMedicalBundle:Settings:form.html.twig', array('asLanguagesData' => $asLanguagesData,'asLocalesData'=>$asLocalesData));
	}
	
	/**
     * function cacheclearAction
     *
     * @param object  $request    request	 
     *
     * @todo   Action for cache clear.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function cacheclearAction(Request $request)
	{	
		$input = new \Symfony\Component\Console\Input\ArgvInput(array('console','cache:clear'));
		$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($this->get('kernel'));
		$tmp = $application->run($input);
		echo 'success';exit;		
	}
}