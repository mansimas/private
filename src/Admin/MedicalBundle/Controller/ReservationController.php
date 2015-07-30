<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class ReservationController extends Controller
{
	/**
     * function indexAction
     *     
     *
     * @todo   Action for display reservations.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager(); 
		$asReservationData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getAllReservationDetail();        
        return $this->render('AdminMedicalBundle:Reservation:index.html.twig', array('asReservationData' => $asReservationData));
    }
	
	/**
     * function reservationdetailAction
     *
     * @param object  $request    request
	 * @param integer $quote_id   quote_id
	 * @param integer $company_id company_id
     *
     * @todo   Action for display selected reservation detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function reservationdetailAction(Request $request, $quote_id, $company_id)
	{
		/* When user click on reservation detail row update that admin view it */
		$em = $this->getDoctrine()->getManager();
		$em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->updateDataByField($quote_id, $company_id);
		
        $asQuoteAllData = $em->getRepository('AdminMedicalBundle:UserCompanyQuotes')->getQuoteAllDetail($quote_id, $company_id);
		
		$snReservationFee = 0;
		if(isset($asQuoteAllData[0]) && count($asQuoteAllData[0]['company']) > 0)
		{
			$snReservationFee = $em->getRepository('AdminMedicalBundle:Company')->calculateReservationFee($asQuoteAllData[0]['company'], $asQuoteAllData[0]['userquotedetails']['usercompanycommunication'][0]['service_price']);
		}
        return $this->render('AdminMedicalBundle:Reservation:reservationdetail.html.twig', array('asQuoteAllData' => $asQuoteAllData,'snReservationFee'=>$snReservationFee));
	}
}