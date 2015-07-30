<?php


namespace Clinic\CommunicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Admin\MedicalBundle\Entity\Company;
use Clinic\CommunicationBundle\Form\ChangePasswordType;
use Clinic\CommunicationBundle\Form\Model\ChangePassword;
use Clinic\CommunicationBundle\Form\Model\ForgotPassword;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class CompanyController extends Controller
{
	/**
     * function loginAction
     *     
     *
     * @todo   Action for clinic login.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function loginAction() 
	{
		$request = $this->getRequest();
        $session = $request->getSession();
//        var_dump($session); exit;
		if($request->isXmlHttpRequest())
		{	
			echo "<script>location.reload();</script>";exit;
		}
		// get the login error if there is one
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
		{
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} 
		else 
		{
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}		
		return $this->render('ClinicCommunicationBundle:Company:login.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME), 'error' => $error));
	}
    
	/**
     * function logincheckAction
     *     
     *
     * @todo   Action for default login check as per symfony structure.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function logincheckAction() 
	{   
    
	}
  
    /**
     * function logoutAction
     *     
     *
     * @todo   Action for default logout as per symfony structure.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function logoutAction() 
	{   
	
	}
	
	/**
     * function changepasswordAction
     *     
     *
     * @todo   Action for clinic change password.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function changepasswordAction(Request $request) 
	{	
		$em = $this->getDoctrine()->getManager();
		$oSession = $this->get('security.context')->getToken()->getUser();
        $cid = $oSession->getId();
		$objComm = $em->getRepository('AdminMedicalBundle:Company')->find($cid);
		
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
		{            
            $newpassword = $form->getData()->newPassword;           
            $entity = new Company();
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $encodedpassword = $encoder->encodePassword($newpassword,'');
            $em->getRepository('AdminMedicalBundle:Company')->changepassword($cid, $encodedpassword);
            return $this->redirect($this->generateUrl('clinic_medical_changepassword',array('objComm'=>$objComm)));            
        }
        return $this->render('ClinicCommunicationBundle:Company:changepassword.html.twig', array('form' => $form->createView(), 'objComm'=>$objComm));
    }
    
	/**
     * function forgotpasswordAction
     *    
     * @param object $request request	 
     *
     * @todo   Action for clinic forgot password.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function forgotpasswordAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
		$forgotPasswordModel = new ForgotPassword();
		$form = $this->createForm(new \Clinic\CommunicationBundle\Form\ForgotPasswordType(), $forgotPasswordModel);
		$form->handleRequest($request);
		$session = $request->getSession();
		if($form->isSubmitted() && $form->isValid()) 
		{
			$cemil = $form->getData()->email;
			$entity = $em->getRepository('AdminMedicalBundle:Company')->findOneByEmail($cemil);
			/* create new password randomly */
			$seed = str_split('abcdefghijklmnopqrstuvwxyz'. '0123456789');
			shuffle($seed);
			$rand = '';
			foreach (array_rand($seed, 10) as $k)
				$rand .= $seed[$k];
			/* encode the randomly created password */
			$companyentity = new Company();
			$factory = $this->get('security.encoder_factory');
			$encoder = $factory->getEncoder($companyentity);
			$encodedpassword = $encoder->encodePassword($rand, '');
			
			/* set new password into database */
			$em->getRepository('AdminMedicalBundle:Company')->changepassword($entity->getId(), $encodedpassword);
			
			/* send email to client containing new password */
			$oNewMailData = $em->getRepository('AdminMedicalBundle:EmailTemplates')->findOneByName('PASSWORD_REMINDER');
			$asMailContent = $oNewMailData->getDescription();
			$ssMailContent = str_replace("{COMPANY_NAME}", $entity->getName(), $asMailContent);
			$ssMailContent = str_replace("{RANDOM_GENERATED_PASSWORD}", $rand, $ssMailContent);
			$this->sendmail($entity->getEmail(), $ssMailContent, $oNewMailData->getTitle());
			$translated = $this->get('translator')->trans('Prašome patikrinti savo elektroninį paštą');
			$session->getFlashBag()->add('success', $translated);
			return $this->redirect($this->generateUrl('clinic_medical_forgotpassword'));
		}
		if($form->isSubmitted() && !$form->isValid())
		{
			$translated = $this->get('translator')->trans('Prašome įvesti teisingą el.pašto adresą');
			$session->getFlashBag()->add('fail', $translated);
        }
		return $this->render('ClinicCommunicationBundle:Company:forgotpassword.html.twig', array('form' => $form->createView()));
	}
	
	/**
     * function sendmail
     *  
     * @param string $to        toemail
	 * @param string $ssBody    mailcontent
	 * @param string $ssSubject subject
     *
     * @todo   Function for send mail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function sendmail($to, $ssBody, $ssSubject)
	{
		$message = \Swift_Message::newInstance()
			->setContentType("text/html")
			->setSubject($ssSubject)
			->setFrom('noreply@medical.lt')
			->setTo($to)
			->setBody($ssBody);
		$this->get('mailer')->send($message);
	}
}