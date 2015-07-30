<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class SpecialoffersController extends Controller
{
	/**
     * function indexAction
     *    
     *
     * @todo   Action for display specialoffers.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();       
        
        $asSpecialOfferData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getAllSpecialOfferDetail();
		
        return $this->render('AdminMedicalBundle:Specialoffers:index.html.twig', array('asSpecialOfferData' => $asSpecialOfferData));
    }
	
	/**
     * function specialoffersdetailAction
     *
     * @param object  $request    request
	 * @param integer $quote_id   specialoffer_id	 
     *
     * @todo   Action for display selected specialoffer detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function specialoffersdetailAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();       
        $em->getRepository('AdminMedicalBundle:SpecialOffers')->updateDataByField($id);
		$em->getRepository('AdminMedicalBundle:SpecialofferSales')->updateDataByField($id);
		
        $asSpecialOfferData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getAllSpecialOfferDetail($id);        
        return $this->render('AdminMedicalBundle:Specialoffers:specialoffersdetail.html.twig', array('asSpecialOfferData' => $asSpecialOfferData));
	}	
	
	/**
     * function specialoffersPDFAction
     *
     * @param object  $request    request
	 * @param integer $id         specialofferid	 
     *
     * @todo   Action for display selected specialdetail in PDF.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function specialoffersPDFAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();       
        $asSpecialOfferData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getAllSpecialOfferDetail($id);
		
		$html12 = $this->renderView('AdminMedicalBundle:Specialoffers:specialoffersPDF.html.twig',array('asSpecialOfferData'=>$asSpecialOfferData));
		$dompdf12 = $this->get('slik_dompdf');

		// Generate the pdf
		$dompdf12->getpdf($html12);		

		// Either stream the pdf to the browser
		return $dompdf12->stream("specialoffer.pdf");		
	}
}