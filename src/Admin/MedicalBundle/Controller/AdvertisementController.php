<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\AdvertiseBanner;
use Admin\MedicalBundle\Form\AdvertiseBannerType;

use Symfony\Component\HttpFoundation\Session\Session;
use Admin\MedicalBundle\Entity\AdvertisementBannerCategory;

class AdvertisementController extends Controller
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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
		
		$em->getRepository('AdminMedicalBundle:AdvertiseBanner')->updateBannerStatus();
        $entities = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->findAll();

        return $this->render('AdminMedicalBundle:Advertisement:index.html.twig', array('entities' => $entities));
    }
    
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
    public function addeditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();        
        $snIdBanner = $request->get('id');
        $objDataBanner = '';
		$ssUniqueId = '';
        if(isset($snIdBanner) && $snIdBanner != '')
        {
            $objBanner = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->find($snIdBanner);			
            $ssDbFileName = $objBanner->getPhoto();
			$ssUniqueId = $objBanner->getUniqueId();
			$form   = $this->createForm(new AdvertiseBannerType($this->container), $objBanner);
        }else{    
		$objBanner = new AdvertiseBanner();	
        $form   = $this->createForm(new AdvertiseBannerType($this->container), $objBanner);}
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);  
			$asDatas = $request->request->all();
			
            if ($form->isValid()) 
            {
                $asData = $request->files->get('admin_medicalbundle_advertise_banner');
				if(is_array($asData) && $asData['photo'] != '')
                {
					$ssFolderPath = $this->get('kernel')->getRootDir() . '/../web/uploads/advertisebanner/';
					
					if(!is_dir($ssFolderPath))
						mkdir($ssFolderPath, 0777);
					
					$ssFilename = $asData['photo']->getClientOriginalName();
					$asFilesData = explode('.', $ssFilename);                
					 
					$ssOriginalFileName = uniqid().'.'.$asFilesData[1];
					$ssTempFilePath = $asData['photo']->getPathName();
					
					$ssImagePath = $ssFolderPath.$ssOriginalFileName;
					move_uploaded_file($ssTempFilePath, $ssImagePath);
					
					if(isset($snIdBanner) && $snIdBanner != '')
					{
					   $objBanner =  $objBanner->setPhoto($ssOriginalFileName);
					   $ssNewFileName = $objBanner->getPhoto();
					   $ssOldFilePath = $ssFolderPath.$ssDbFileName;
					   /* delete old file*/
					   if(isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath))
					   {
						   unlink($ssOldFilePath);
					   }
					}
					else 
					{
					   $objBanner->setPhoto($ssOriginalFileName); 
					}
				}
				else
				{
					if(isset($snIdBanner) && $snIdBanner != '')
                    {
                        $objBanner->setPhoto($ssDbFileName); 
                    }
					else
					{	
						$objBanner->setUniqueId($asDatas['unique_id']);						
					}
				}
				
				if(!isset($snIdBanner) && $snIdBanner == '')
				{
					$objBanner->setCurrentShows(0); 
				}
					
                $em->persist($objBanner);                
                $em->flush(); 
                $snId = $objBanner->getId();
				$oBanner = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->find($snId);
				$asIds = array();
				if(isset($snIdBanner) && $snIdBanner != '' && count($asDatas['admin_medicalbundle_advertise_banner']['categories']) > 0)
				{				
					foreach($oBanner->getBanners() as $snKey)
						$asIds[] = $snKey->getId();					
					if(count($asIds) > 0)
						$em->getRepository('AdminMedicalBundle:AdvertisementBannerCategory')->deleteData(implode($asIds, ','));									
				}
				
				if(isset($asDatas['admin_medicalbundle_advertise_banner']['categories']) && ($asDatas['admin_medicalbundle_advertise_banner']['categories']) > 0)
				{
					foreach($asDatas['admin_medicalbundle_advertise_banner']['categories'] as $snKey=>$ssVal)
					{
						$oCate = $em->getRepository('AdminMedicalBundle:Category')->find($ssVal);
						$oRoot = $em->getRepository('AdminMedicalBundle:Category')->find($oCate->getRootId());
						$oCompCate = new AdvertisementBannerCategory();
						$oCompCate->setBanner($oBanner);
						$oCompCate->setCategories($oCate);
						$oCompCate->setRoots($oRoot);
						$em->persist($oCompCate);
						$em->flush();
					}					
				}
                $session = $request->getSession();
                
                if(isset($snIdBanner) && $snIdBanner != '')
                    $session->getFlashBag()->add('success', 'Record updated successfully');
                else
                    $session->getFlashBag()->add('success', 'Record added successfully');
                
                return $this->redirect($this->generateUrl('medical_advertisement'));               
            }			
        }
        return $this->render('AdminMedicalBundle:Advertisement:addedit.html.twig', array('form' => $form->createView(),'objDataBanner'=>$objBanner,'ssUniqueId'=>$ssUniqueId));
    }
	
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
	public function deleteAction(Request $request)
    {
        if ($request->isMethod('POST')) 
		{
			$asIds = $request->request->all();
			$asIds = implode(',', $asIds['chk_delete']);
			
			$em = $this->getDoctrine()->getManager();
			$asData = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->getBannerDetail($asIds);
			
			if(count($asData) > 0)
			{
				foreach($asData as $snKey=>$ssVal)
				{
					$ssPath = $this->container->getParameter('web_path').'advertisebanner/'.$ssVal['photo'];				
					if(file_exists($ssPath))
						unlink($ssPath);
				}
			}
			$ssFlag = $em->getRepository('AdminMedicalBundle:AdvertiseBanner')->deleteData($asIds);
			
			if($ssFlag)
			{
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'Record deleted successfully');
				return $this->redirect($this->generateUrl('medical_advertisement'));
			}           
		}
	}
}