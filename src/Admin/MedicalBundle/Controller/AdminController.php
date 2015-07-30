<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Admin\MedicalBundle\Entity\Admin;

class AdminController extends Controller
{
    /**
     * function loginAction
     *
     *
     * @todo Action for login.
     * @access public
     * @author Sagar Thesia <sagar.t.php@gmail.com>
     * @return
     */
	public function loginAction()
    {
		$request = $this->getRequest();
		$session = $request->getSession();

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
		// last username entered by the user
		return $this->render('AdminMedicalBundle:Admin:login.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME),'error' => $error,));
    }
	
	/**
     * function logincheckAction
     *
     *
     * @todo Action for check login.
     * @access public
     * @author Sagar Thesia <sagar.t.php@gmail.com>
     * @return
     */
	public function logincheckAction()
	{    
	}

	/**
     * function logoutAction
     *
     *
     * @todo Action for logout.
     * @access public
     * @author Sagar Thesia <sagar.t.php@gmail.com>
     * @return
     */
	public function logoutAction()
	{
		return $this->render('AdminMedicalBundle:Admin:login.html.twig');
	}
}