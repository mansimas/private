<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\Testimonialvideo;
use Admin\MedicalBundle\Form\TestimonialVideoType;

use Admin\MedicalBundle\Entity\Video;
use Admin\MedicalBundle\Form\VideoType;

class VideoController extends Controller
{
	/**
     * function indexAction
     *
	 * @param  object  $request request
     *
     * @todo   Action for display video.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();        
        $asVideoData = $em->getRepository('AdminMedicalBundle:Video')->getAllVideos();
        
		$session = $request->getSession();
		if($request->get('status') != '')
		{
			if($request->get('status') == 'Active')
			{
				$asData = $em->getRepository('AdminMedicalBundle:Video')->getActiveVideoDetails('Active');			
				
				if(is_array($asData) && !empty($asData) && $asData[0]['active_count'] < 1)
				{
					$em->getRepository('AdminMedicalBundle:Video')->updateVideoStatus($request->get('id'), $request->get('status'));			
					$session->getFlashBag()->add('success', 'Video active successfully');
				}
				else
				{
					$session->getFlashBag()->add('error', 'Maximum 1 video you can active');
				}			
			}
            else
			{
				$em->getRepository('AdminMedicalBundle:Video')->updateVideoStatus($request->get('id'), $request->get('status'));
				$session->getFlashBag()->add('success', 'Video inactive succesfully');
				return $this->redirect($this->generateUrl('medical_video'));
			}
			return $this->redirect($this->generateUrl('medical_video'));
		}
        return $this->render('AdminMedicalBundle:Video:index.html.twig', array('asVideoData' => $asVideoData));
    }
	
	/**
     * function addeditAction
     *
	 * @param  object  $request request
     *
     * @todo   Action for add/edit video.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function addeditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdVideo = $request->get('id');
       
        if(isset($snIdVideo) && $snIdVideo != '')
			$objVideos = $em->getRepository('AdminMedicalBundle:Video')->find($snIdVideo);        
        else
			$objVideos = new Video();
        
        $form   = $this->createForm(new VideoType($this->container), $objVideos);
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
				$objVideos->setStatus('InActive');
                $em->persist($objVideos);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdVideo) && $snIdVideo != '')
                    $session->getFlashBag()->add('success', 'Record updated succesfully');
                else
                    $session->getFlashBag()->add('success', 'Record added succesfully');
                return $this->redirect($this->generateUrl('medical_video'));
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
        return $this->render('AdminMedicalBundle:Video:addedit.html.twig', array('form' => $form->createView(),'asLanguageCode' =>$asLanguageCode));
    }
	
	/**
     * function testimonialvideoAction
     *	 
     *
     * @todo   Action for testimonial video.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function testimonialvideoAction()
    {
        $em = $this->getDoctrine()->getManager();       
        
        $asTestimonialVideoData = $em->getRepository('AdminMedicalBundle:Testimonialvideo')->getAllTestimonialVideoDetail();
        
        return $this->render('AdminMedicalBundle:Video:testimonialvideo.html.twig', array('asTestimonialVideoData' => $asTestimonialVideoData));
    }
	
	/**
     * function testimonialaddeditAction
     *
	 * @param  object  $request request
     *
     * @todo   Action for add/edit testimonial video.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function testimonialaddeditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdVideo = $request->get('id');
       
        if(isset($snIdVideo) && $snIdVideo != '')
			$objVideos = $em->getRepository('AdminMedicalBundle:Testimonialvideo')->find($snIdVideo);        
        else
			$objVideos = new Testimonialvideo();
        
        $form   = $this->createForm(new TestimonialVideoType(), $objVideos);
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
                $em->persist($objVideos);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdVideo) && $snIdVideo != '')
                    $session->getFlashBag()->add('success', 'Record updated successfully');
                else
                    $session->getFlashBag()->add('success', 'Record added successfully');
                return $this->redirect($this->generateUrl('medical_testimonial_video'));
            }                     
        }
        return $this->render('AdminMedicalBundle:Video:testimonialaddedit.html.twig', array('form' => $form->createView()));
    }
	
	/**
     * function deleteAction
     *
	 * @param  object  $request request
     *
     * @todo   Action for delete video.
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
			
			if(isset($asData['delete']) && $asData['delete'] == 'Delete')
			{				
				$ssFlag = $em->getRepository('AdminMedicalBundle:Video')->deleteData($asIds);				
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record deleted succesfully');
				}
			}
			return $this->redirect($this->generateUrl('medical_video'));
		}
	}
	
	/**
     * function testimonialdeleteAction
     *
	 * @param  object  $request request
     *
     * @todo   Action for delete testimonial video.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function testimonialdeleteAction(Request $request)
    {
	    if ($request->isMethod('POST')) 
		{
			$asData = $request->request->all();			
			$asIds = implode(',', $asData['chk_delete']);
			
			$session = $request->getSession();
			$em = $this->getDoctrine()->getManager();
			
			if(isset($asData['delete']) && $asData['delete'] == 'Delete')
			{				
				$ssFlag = $em->getRepository('AdminMedicalBundle:Testimonialvideo')->deleteData($asIds);				
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record deleted succesfully');
				}
			}
			return $this->redirect($this->generateUrl('medical_testimonial_video'));
		}
	}	
}