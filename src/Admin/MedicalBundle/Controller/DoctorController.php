<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\MedicalBundle\Entity\Doctor;
use Admin\MedicalBundle\Form\DoctorType;
use Symfony\Component\HttpFoundation\Session\Session;

class DoctorController extends Controller
{
	/**
     * function indexAction
     *
     *
     * @todo Action for displaying news.
     * @access public
     * @author Sagar Thesia <sagar.t.php@gmail.com>
     * @return
     */
	public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $asDoctorsData = $em->getRepository('AdminMedicalBundle:Doctor')->getAllDoctorsDetail();
        return $this->render('AdminMedicalBundle:Doctor:index.html.twig', array('asDoctorsData' => $asDoctorsData));
    }
    
	/**
     * function addeditAction
	 *
     * @param object $request request
     *
     * @todo Action for add news.
     * @access public
     * @author Sagar Thesia <sagar.t.php@gmail.com>
     * @return
     */
	public function addeditAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
        $snIdDoctor = $request->get('id');
        $objDataNews = "";
        if(isset($snIdDoctor) && $snIdDoctor != '')
        {
            $objDoctor = $em->getRepository('AdminMedicalBundle:Doctor')->find($snIdDoctor);
            $ssDbFileName = $objDoctor->getPhoto();
        }
        else
		{
			$objDoctor = new Doctor();
		}
        $form   = $this->createForm(new DoctorType($this->container), $objDoctor);
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
                $asData = $request->files->get('admin_medicalbundle_doctor');                
                if(is_array($asData) && $asData['photo'] != '')
                {
                    $ssFolderPath = $this->container->getParameter('web_path').'doctor/';
                    if(!is_dir($ssFolderPath))
                        mkdir($ssFolderPath);
                    $ssFilename = $asData['photo']->getClientOriginalName();
                    $asFilesData = explode('.', $ssFilename);                
                    $ssOriginalFileName = uniqid().'.'.$asFilesData[1];
                    $ssTempFilePath = $asData['photo']->getPathName();
                    $ssImagePath = $ssFolderPath.$ssOriginalFileName;
                    move_uploaded_file($ssTempFilePath, $ssImagePath);
                    if(isset($snIdDoctor) && $snIdDoctor != '')
                    {
                       $objDoctor =  $objDoctor->setPhoto($ssOriginalFileName);
                       $ssNewFileName = $objDoctor->getPhoto();
                       $ssOldFilePath = $ssFolderPath.$ssDbFileName;
                       /* delete old file*/
                       if(isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath))
                       {
                           unlink($ssOldFilePath);
                       }
                    }
                    else                    
                       $objDoctor->setPhoto($ssOriginalFileName); 
                }
                else
				{
                    if(isset($snIdDoctor) && $snIdDoctor != '')
                    {
                        $objDoctor->setPhoto($ssDbFileName); 
                    }
                }
                $em->persist($objDoctor);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdDoctor) && $snIdDoctor != '')
                    $session->getFlashBag()->add('success', 'Record updated successfully');
                else
                    $session->getFlashBag()->add('success', 'Record added successfully');
                return $this->redirect($this->generateUrl('medical_doctor'));
            }                     
        }
        return $this->render('AdminMedicalBundle:Doctor:addedit.html.twig', array('form' => $form->createView(),'objDoctor'=>$objDoctor));
    }
    
	/**
     * function deleteAction
	 *
     * @param object $request request
     *
     * @todo Action for delete news.
     * @access public
     * @author Sagar Thesia <sagar.t.php@gmail.com>
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
				$asData = $em->getRepository('AdminMedicalBundle:Doctor')->getDoctorsDetail($asIds);
				if(count($asData) > 0)
				{
					foreach($asData as $snKey=>$ssVal)
					{
						$ssPath = $this->container->getParameter('web_path').'doctor/'.$ssVal['photo'];				
						if(file_exists($ssPath))
							unlink($ssPath);
					}
				}
				$ssFlag = $em->getRepository('AdminMedicalBundle:Doctor')->deleteData($asIds);
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record deleted successfully');
				}
			}
			return $this->redirect($this->generateUrl('medical_doctor'));
		}
	}
}