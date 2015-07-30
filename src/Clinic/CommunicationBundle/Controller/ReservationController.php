<?php

namespace Clinic\CommunicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\UserCompanyCommunication;

class ReservationController extends Controller
{
	/**
     * function indexAction
     *
     * @param object $request request
     *
     * @todo   Action for display resrevation listing.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction(Request $request)
    {		
		$em = $this->getDoctrine()->getManager();       
        $oSession = $this->get('security.context')->getToken()->getUser();
        $asReservationData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getReservationDetail($oSession->getId());		
		
        return $this->render('ClinicCommunicationBundle:Reservation:index.html.twig', array('asReservationData' => $asReservationData));
    }
	
	/**
     * function reservationdetailAction
     *
     * @param object $request request
     *
     * @todo   Action for display resrevation detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function reservationdetailAction(Request $request, $quote_id)
    {
		$oSession = $this->get('security.context')->getToken()->getUser();
		$company_id = $oSession->getId();
		
		/* When user click on reservation detail row update that admin view it */
		$em = $this->getDoctrine()->getManager();		
		$em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField($quote_id, $company_id, 'Yes', 'checked_by_company');
		
        $asQuoteAllData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getQuoteAllDetail($quote_id, $company_id);
		
		$snReservationFee = $em->getRepository('AdminMedicalBundle:Company')->calculateReservationFee($asQuoteAllData[0]['company'], $asQuoteAllData[0]['userquotedetails']['usercompanycommunication'][0]['service_price']);
        
        return $this->render('ClinicCommunicationBundle:Reservation:reservationdetail.html.twig', array('asQuoteAllData' => $asQuoteAllData,'snReservationFee'=>$snReservationFee));	
	}
}