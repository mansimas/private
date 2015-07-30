<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{	
	/**
     * function indexAction
     *	 
	 * @param  string  $name name
     *
     * @todo   Action for display email templates.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction($name)
    {
        return $this->render('AdminMedicalBundle:Default:index.html.twig', array('name' => $name));
    }
	
	/**
     * function sidebarAction
     *	 
     *
     * @todo   Action for display email templates.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function sidebarAction()
    {
		
		$em = $this->getDoctrine()->getManager();
		$asCountPaidReservationQuote = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->countByCheckedAdmin();		
		$asCountNewSaleOffer = $em->getRepository('AdminMedicalBundle:SpecialofferSales')->countByCheckedAdmin();		
		$asCountNewQuote = $em->getRepository('AdminMedicalBundle:UserQuoteDetail')->countByCheckedAdmin();		
		return $this->render('AdminMedicalBundle:Default:sidebar.html.twig',array('asCountNewQuote'=>$asCountNewQuote,'asCountPaidReservationQuote'=>$asCountPaidReservationQuote,'asCountNewSaleOffer'=>$asCountNewSaleOffer));
    }
}