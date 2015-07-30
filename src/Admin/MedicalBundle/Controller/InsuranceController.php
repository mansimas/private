<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\Insurance;
use Admin\MedicalBundle\Form\InsuranceType;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Insurance controller.
 * Test commit
 */
class InsuranceController extends Controller
{

    /**
     * function indexAction
     *
     * @param object $request request
     *
     * @todo   Action for display insurance.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminMedicalBundle:Insurance')->findAll();
        return $this->render('AdminMedicalBundle:Insurance:index.html.twig', array('entities' => $entities,'pagination' => $entities));
    }
    
	/**
     * function addeditAction
     *
     * @param object $request request
     *
     * @todo   Action for addedit insurance.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function addeditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdInsurance = $request->get('id');
        if(isset($snIdInsurance) && $snIdInsurance != '')
		{
            $oInsurance = $em->getRepository('AdminMedicalBundle:Insurance')->find($snIdInsurance);
			$ssDbFileName = $oInsurance->getPhoto();
		}
        else
            $oInsurance = new Insurance();
        
        $objInsurance = $this->createForm(new InsuranceType($this->container), $oInsurance);
        
        if ($request->isMethod('POST')) 
		{
            $objInsurance->bind($request);            
            if ($objInsurance->isValid()) 
            {        
				$asData = $request->files->get('admin_medicalbundle_insurance');                
                if(is_array($asData) && $asData['photo'] != '')
                {
                    $ssFolderPath = $this->container->getParameter('web_path').'insurance/';

                    if(!is_dir($ssFolderPath))
                        mkdir($ssFolderPath, 0777);

                    $ssFilename = $asData['photo']->getClientOriginalName();
                    $asFilesData = explode('.', $ssFilename);                

                    $ssOriginalFileName = uniqid().'.'.$asFilesData[1];
                    $ssTempFilePath = $asData['photo']->getPathName();

                    $ssImagePath = $ssFolderPath.$ssOriginalFileName;
                    move_uploaded_file($ssTempFilePath, $ssImagePath);

                    if(isset($snIdInsurance) && $snIdInsurance != '')
                    {
                       $oInsurance =  $oInsurance->setPhoto($ssOriginalFileName);
                       $ssNewFileName = $oInsurance->getPhoto();
                       $ssOldFilePath = $ssFolderPath.$ssDbFileName;
                       /* delete old file*/
                       if(isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath))
                       {
                           unlink($ssOldFilePath);
                       }
                    }
                    else                    
                       $oInsurance->setPhoto($ssOriginalFileName); 
                }
				else {
                    if(isset($snIdInsurance) && $snIdInsurance != '')
                    {
                        $oInsurance->setPhoto($ssDbFileName); 
                    }
                }
                $em->persist($oInsurance);                
                $em->flush();                
                $session = $request->getSession();
                if(isset($snIdInsurance) && $snIdInsurance != '')
                    $session->getFlashBag()->add('success', 'Record updated succesfully');
                else
                    $session->getFlashBag()->add('success', 'Record added succesfully');
                return $this->redirect($this->generateUrl('medical_insurance',array('page'=> $request->get('page'))));
            }
        }
        return $this->render('AdminMedicalBundle:Insurance:addedit.html.twig', array('form'   => $objInsurance->createView(),'oInsurance'=>$oInsurance));
    }  
    
	/**
     * function deleteAction
     *
     * @param object $request request
     *
     * @todo   Action for delete insurance.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function deleteAction(Request $request)
    {
        if ($request->isMethod('POST')) 
		{
			$asInsuranceIds = $request->request->all();
			$asInsuranceIds = implode(',', $asInsuranceIds['chk_delete']);
			
			$em = $this->getDoctrine()->getManager();
			$asData = $em->getRepository('AdminMedicalBundle:Insurance')->getInsurancesDetail($asInsuranceIds);
			if(count($asData) > 0)
			{
				foreach($asData as $snKey=>$ssVal)
				{
					$ssPath = $this->container->getParameter('web_path').'insurance/'.$ssVal['photo'];				
					if(file_exists($ssPath))
						unlink($ssPath);
				}
			}
			$ssFlag = $em->getRepository('AdminMedicalBundle:Insurance')->deleteData($asInsuranceIds);
			if($ssFlag)
			{
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'Record deleted succesfully');
				return $this->redirect($this->generateUrl('medical_insurance'));
			}           
		}
	}
}