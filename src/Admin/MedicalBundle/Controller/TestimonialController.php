<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\Testimonial;
use Admin\MedicalBundle\Form\TestimonialType;

use Symfony\Component\HttpFoundation\Session\Session;

class TestimonialController extends Controller
{
	/**
     * function indexAction
     *		 
     * @todo   Action for display testimonial.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();       
        $asTestimonialData = $em->getRepository('AdminMedicalBundle:Testimonial')->findAll();
        return $this->render('AdminMedicalBundle:Testimonial:index.html.twig', array('asTestimonialData' => $asTestimonialData));
    }
    
	/**
     * function addeditAction
     *	 
	 * @param  object  $request request
     *
     * @todo   Action for add/edit testimonial.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function addeditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdTestimonial = $request->get('id');
        if(isset($snIdTestimonial) && $snIdTestimonial != '')
        {
            $objTestimonial = $em->getRepository('AdminMedicalBundle:Testimonial')->find($snIdTestimonial);            
        }
        else
            $objTestimonial = new Testimonial();
        $form   = $this->createForm(new TestimonialType($this->container), $objTestimonial);
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if($form->isValid()) 
            {
                $asData = $request->files->get('admin_medicalbundle_testimonial');                
                $em->persist($objTestimonial);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdTestimonial) && $snIdTestimonial != '')
                    $session->getFlashBag()->add('success', 'Record updated successfully');
                else
                    $session->getFlashBag()->add('success', 'Record added successfully');
                return $this->redirect($this->generateUrl('medical_testimonial'));
            }                     
        }
		$asLanguageData = $em->getRepository('AdminMedicalBundle:Languages')->findAll();
		if(is_array($asLanguageData) && !empty($asLanguageData))
		{
			foreach($asLanguageData as $snKey=>$asVal)
				$asLanguageCode[] = $asVal->getCode();
		}
		else
			$asLanguageCode = $this->container->getParameter('default_locales');
        return $this->render('AdminMedicalBundle:Testimonial:addedit.html.twig', array('form' => $form->createView(),'objTestimonial'=>$objTestimonial,'asLanguageCode' => $asLanguageCode));
    }

	/**
     * function deleteAction
     *	 
	 * @param  object  $request request
     *
     * @todo   Action for delete testimonial.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function deleteAction(Request $request)
    {
        if ($request->isMethod('POST')) 
		{
			$asIds = $request->request->all();
			$asIds = implode(',', $asIds['chk_delete']);			
			$em = $this->getDoctrine()->getManager();			
			$ssFlag = $em->getRepository('AdminMedicalBundle:Testimonial')->deleteData($asIds);			
			if($ssFlag)
			{
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'Record deleted succesfully');
				return $this->redirect($this->generateUrl('medical_testimonial'));
			}           
		}
	}
}