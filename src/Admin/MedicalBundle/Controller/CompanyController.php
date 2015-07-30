<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\MedicalBundle\Entity\Category;

use Admin\MedicalBundle\Entity\Company;
use Admin\MedicalBundle\Form\CompanyType;

use Admin\MedicalBundle\Entity\SpecialOffers;
use Admin\MedicalBundle\Form\SpecialOffersType;

use Admin\MedicalBundle\Entity\Ratings;
use Admin\MedicalBundle\Form\RatingsType;

use Admin\MedicalBundle\Entity\Service;
use Admin\MedicalBundle\Form\ServiceType;

use Admin\MedicalBundle\Entity\Experience;
use Admin\MedicalBundle\Form\ExperienceType;

use Admin\MedicalBundle\Entity\Doctor;
use Admin\MedicalBundle\Form\DoctorType;

use Admin\MedicalBundle\Entity\Prices;
use Admin\MedicalBundle\Form\PricesType;

use Symfony\Component\HttpFoundation\Session\Session;

use Admin\MedicalBundle\Entity\CompanyCategory;

/**
 * Company controller.
 *
 */
class CompanyController extends Controller
{

    /**
     * function indexAction
     *	
     *
     * @todo   Action for display company.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminMedicalBundle:Company')->getAllCompanyDetailsWithClient();		
        return $this->render('AdminMedicalBundle:Company:index.html.twig', array('entities' => $entities));
    }
	
    /**
     * function imageuploadAction
     *	
	 * @param object $request request
     *
     * @todo   Action for upload image.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function imageuploadAction(Request $request)
    {
        $targetPath = $this->container->getParameter('web_path').'company/';
        if ($request->isXmlHttpRequest() && !empty($_FILES)) 
        {
            if(!is_dir($targetPath))
                mkdir ($targetPath, 0777);
            $tempDirPath = $targetPath.'temp/';
            if(!is_dir($tempDirPath))
                mkdir ($tempDirPath, 0777);
            
            $tempFile = $_FILES['file']['tmp_name'];
            $ssFileName = $_FILES['file']['name'];
            
            $asFilesData = explode('.', $ssFileName);
            $ssOriginalFileName = uniqid().'.'.$asFilesData[1];                    
            
            $targetFile =  $tempDirPath. $ssOriginalFileName;            
            move_uploaded_file($tempFile,$targetFile);
            echo "success";
            exit;
        }
        elseif($request->isXmlHttpRequest())
        {
            $result  = array();            
            $storeFolder = $targetPath.$request->get('id');
            if(is_dir($storeFolder))
            {
                $files = scandir($storeFolder);
                if ( false!==$files ) {
                    foreach ( $files as $file ) {
                        if ( '.'!=$file && '..'!=$file) {                           
                            $obj['name'] = $file;
                            $obj['size'] = filesize($storeFolder.'/'.$file);
                            $result[] = $obj;
                        }
                        }
                    }
                header('Content-type: text/json');
                header('Content-type: application/json');
                echo json_encode($result);
                exit;
            }
            else
            {
                $result[] = array("msg"=>"No images");
                echo json_encode($result);;
                exit;
            }
        }
    }
    
    /**
     * function removeimageAction
     *
     * @param object $request request	 
     *
     * @todo   Action for remove image.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function removeimageAction(Request $request)
    {   
        $targetPath = $this->container->getParameter('web_path').'company/';        
        if ($request->isXmlHttpRequest() && $request->get('name') != '' && $request->get('comp_id') != '')
        {
            $snCompanyId = $request->get('comp_id');
            $ssFileName = $request->get('name');
            $ssSourcePath = $targetPath.$snCompanyId.'/';
            $ssDestinationPath = $ssSourcePath.'temp_delete/';
            if(!is_dir($ssDestinationPath))
                mkdir ($ssDestinationPath, 0777);
            copy($ssSourcePath.$ssFileName, $ssDestinationPath.$ssFileName);
            echo "success";exit;
        }
        echo "";exit;
    }
    
    /**
     * Displays a form to create a new Company entity.
     *
     */
    public function testAction(Request $request, $name)
    {
        echo $request->get('id');
        echo $name;exit;
    }
    
    /**
     * function addeditAction
     *	
	 * @param object $request request
     *
     * @todo   Action for add/edit company detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function addeditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();       
        $asSpecialOffersData = '';        
        $asRatingData =  ''; 
        $asVideoData = array();
        $snIdCompany = $request->get('id');
        $ssUniqueId = '';
		$asServiceData = array();
		$asExperienceData = array();		
		$asPricesData = array();
        if(isset($snIdCompany) && $snIdCompany != '')
        {         
            $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);


            if(!$entity)
			{
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'This company does not exist');				
				return $this->redirect($this->generateUrl('medical_company'));
			}
            $asSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getSpecialOfferDetail($snIdCompany);			
            $asRatingData = $em->getRepository('AdminMedicalBundle:Ratings')->getRatingDetail($snIdCompany);            
            $asServiceData = $em->getRepository('AdminMedicalBundle:Service')->getServiceDetail($snIdCompany);
            $asExperienceData = $em->getRepository('AdminMedicalBundle:Experience')->getExperienceDetail($snIdCompany);            
			$asPricesData = $em->getRepository('AdminMedicalBundle:Prices')->getPricesDetail($snIdCompany);
			$asVideoData = $em->getRepository('AdminMedicalBundle:CompanyVideo')->getVideoDetail($snIdCompany);			
		}
        else
		{
			// for selectes country lithunia for it id is 122 in country table
			$entity = new Company();			
			$ocountry = $em->getRepository('AdminMedicalBundle:Country')->find(122);
			$entity->setCountries($ocountry);			
			$ssPhoto = '';
		}		
		$form   = $this->createForm(new CompanyType($this->container), $entity);
        
		$snIdSpecialOffer = $request->get('special_id');
		if(isset($snIdSpecialOffer) && $snIdSpecialOffer != '')
		{
			$asTotalSalesCount = $em->getRepository('AdminMedicalBundle:SpecialOffers')->getCountSpecialOfferSales($snIdSpecialOffer);
			$snTotalSalesCountId = ((count($asTotalSalesCount) > 0) ? $asTotalSalesCount[0][1] : 0);
            $oSpecialOffers = $em->getRepository('AdminMedicalBundle:SpecialOffers')->find($snIdSpecialOffer);
			$ssPhoto = $oSpecialOffers->getPhoto();
			$ssUniqueId = $oSpecialOffers->getUniqueId();
		}
        else
		{
			$snTotalSalesCountId = 0;
			$oSpecialOffers = new SpecialOffers();
			$ssPhoto = '';
		}
		
        $objSpecialOffers = $this->createForm(new SpecialOffersType($this->container), $oSpecialOffers);
        
        $snIdRate = $request->get('rate_id');
        if(isset($snIdRate) && $snIdRate != '')
            $oRatings = $em->getRepository('AdminMedicalBundle:Ratings')->find($snIdRate);
        else
            $oRatings = new Ratings();			
			
        $objRatings = $this->createForm(new RatingsType(), $oRatings );
        
        if(isset($asServiceData) && is_array($asServiceData) && !empty($asServiceData))
            $oService = $em->getRepository('AdminMedicalBundle:Service')->find($asServiceData[0]['id']);
        else
            $oService = new Service();
        $objService = $this->createForm(new ServiceType($this->container), $oService);
        
        if(isset($asExperienceData) && is_array($asExperienceData) && !empty($asExperienceData))
            $oExperience = $em->getRepository('AdminMedicalBundle:Experience')->find($asExperienceData[0]['id']);
        else
            $oExperience = new Experience();
        $objExperience = $this->createForm(new ExperienceType($this->container), $oExperience);
		
		if(isset($asPricesData) && is_array($asPricesData) && !empty($asPricesData))
            $oPrice = $em->getRepository('AdminMedicalBundle:Prices')->find($asPricesData[0]['id']);
        else
            $oPrice = new Prices();
        $objPrice = $this->createForm(new PricesType($this->container), $oPrice);
		
        if ($request->isMethod('POST')) 
		{
			$form->bind($request);            
            if ($form->isValid()) 
            {
                $em->persist($entity);                
                $em->flush();				
                $snId = $entity->getId(); 
				
				$asData = $request->request->all();
				
				$oComp = $em->getRepository('AdminMedicalBundle:Company')->find($snId);
				$asIds = array();
				if(isset($snIdCompany) && $snIdCompany != '' && count($asData['admin_medicalbundle_company']['categories']) > 0)
				{				
					foreach($oComp->getCategory() as $snKey)
						$asIds[] = $snKey->getId();					
					if(count($asIds) > 0)
						$em->getRepository('AdminMedicalBundle:CompanyCategory')->deleteData(implode($asIds, ','));									
				}
				if(($asData['admin_medicalbundle_company']['categories']) > 0)
				{
					foreach($asData['admin_medicalbundle_company']['categories'] as $snKey=>$ssVal)
					{
						$oCate = $em->getRepository('AdminMedicalBundle:Category')->find($ssVal);
						$oRoot = $em->getRepository('AdminMedicalBundle:Category')->find($oCate->getRootId());
						$oCompCate = new CompanyCategory();
						$oCompCate->setCompany($oComp);
						$oCompCate->setCategories($oCate);
						$oCompCate->setRoots($oRoot);
						$em->persist($oCompCate);
						$em->flush();
					}					
				}
				if(isset($asData['url']) && count($asData['url']) > 0)
				{
					$em->getRepository('AdminMedicalBundle:CompanyVideo')->saveData($asData['url'], $snId, $entity);
                }
				if(isset($asData['deleteurl']) && count($asData['deleteurl']) > 0)
				{	
					$asIds = implode(',', $asData['deleteurl']);
					$em->getRepository('AdminMedicalBundle:CompanyVideo')->deleteData($asIds);
				}
                $this->uploadCompanyImages($snId, $em, $entity);                               
                $this->removeCompanyImages($snId, $em, $entity);   
                $session = $request->getSession();
                if(isset($snIdCompany) && $snIdCompany != '')
                    $session->getFlashBag()->add('success', 'Record updated successfully');
                else
                    $session->getFlashBag()->add('success', 'Record added successfully');
                return $this->redirect($this->generateUrl('medical_company'));
            }
        }
		$snParentId = 0;		
        return $this->render('AdminMedicalBundle:Company:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'objSpecialOffers' => $objSpecialOffers->createView(),
            'objRatings'   => $objRatings->createView(),
			'oRatings' => $oRatings,
            'asSpecialOffersData' => $asSpecialOffersData,
            'asRatingData' => $asRatingData,
            'objService' => $objService->createView(),
            'objExperience' => $objExperience->createView(),                       
			'asServiceData'=>$asServiceData,
			'asExperienceData'=>$asExperienceData,			
			'asPricesData'=>$asPricesData,
			'asVideoData'=>$asVideoData,
			'ssUniqueId'=>$ssUniqueId,
			'ssPhoto' => $ssPhoto,
			'objPrice' => $objPrice->createView(),
			'snTotalSalesCountId' => $snTotalSalesCountId,			
        ));        
    }
	
	/**
     * function specialofferAction
     *
     * @param object $request request	 
     *
     * @todo   Action for add/edit specialoffer detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function specialofferAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();       
        $snIdCompany = $request->get('id');        
        if(isset($snIdCompany) && $snIdCompany != '')
            $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);            
        else
            $entity = new Company();
		$snIdSpecial = $request->get('special_id');
		if(isset($snIdSpecial) && $snIdSpecial != '')
		{
            $oSpecialOffers = $em->getRepository('AdminMedicalBundle:SpecialOffers')->find($snIdSpecial);
			$ssDbFileName = $oSpecialOffers->getPhoto();
		}
        else
            $oSpecialOffers = new SpecialOffers();
        		
        $objSpecialOffers = $this->createForm(new SpecialOffersType($this->container), $oSpecialOffers);       
        if ($request->isMethod('POST')) 
		{   
			$objSpecialOffers->bind($request);           
            if ($objSpecialOffers->isValid()) 
            {
				$asData = $request->files->get('admin_medicalbundle_specialoffers');
				$asLastSpecialOffersData = $em->getRepository('AdminMedicalBundle:SpecialOffers')->findBy(array(),array('id'=>'DESC'), 1);			
				if(isset($asLastSpecialOffersData) && count($asLastSpecialOffersData) > 0)
				{
					$asData = $asLastSpecialOffersData[0];
					$ssUniqueId = "S".($asData->getId() + 1).date('dmy');
					$oSpecialOffers->setUniqueId($ssUniqueId);					
				}
				else
				{
					$ssUniqueId = "S1".date('dmy');
					$oSpecialOffers->setUniqueId($ssUniqueId);
				}			
                $oSpecialOffers->setCompany($entity);                
                $em->persist($oSpecialOffers);                
                $em->flush();                
				$snId = $oSpecialOffers->getId();
				$this->uploadCompanyImages($snId, $em, $oSpecialOffers, 'specialoffer');
                $this->removeCompanyImages($snId, $em, $oSpecialOffers, 'specialoffer');				
				$session = $request->getSession();
                $session->getFlashBag()->add('success', 'Record updated successfully');
                return $this->redirect($this->generateUrl('medical_company_addedit', array('id' => $snIdCompany)));
            }
			else
			{
				echo "<pre>";				
				print_r($objSpecialOffers->getErrors());
				exit;
			}
        }
    }
    
	/**
     * function ratingAction
     *	
	 * @param object $request request
     *
     * @todo   Action for add/edit rating detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function ratingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdCompany = $request->get('id');
        $snIdRate = $request->get('rate_id');
        if(isset($snIdCompany) && $snIdCompany != '')
            $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);
        if(isset($snIdRate) && $snIdRate != '')
            $oRatings = $em->getRepository('AdminMedicalBundle:Ratings')->find($snIdRate);
        else
            $oRatings = new Ratings();
        $objRatings = $this->createForm(new RatingsType(), $oRatings);
        
        if($request->isMethod('POST')) 
		{
            $objRatings->bind($request);           
            if ($objRatings->isValid()) 
            {   
				$oRatings->setVerifyFlag(1);
                $oRatings->setCompany($entity);                
                $em->persist($oRatings);                
                $em->flush();
                $session = $request->getSession();             
                $session->getFlashBag()->add('success', 'Record updated successfully');
                return $this->redirect($this->generateUrl('medical_company_addedit', array('id' => $snIdCompany,'rate_id' => $snIdRate)));
            }
        }
    }
	
	/**
     * function serviceAction
     *	
	 * @param object $request request
     *
     * @todo   Action for add/edit service detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function serviceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdCompany = $request->get('id');
        
        if(isset($snIdCompany) && $snIdCompany != '')
            $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);

        $snIdService = $request->get('service_id');
        if(isset($snIdService) && $snIdService != '')
            $oService = $em->getRepository('AdminMedicalBundle:Service')->find($snIdService);
        else
            $oService = new Service();       
        $objService = $this->createForm(new ServiceType($this->container), $oService);        
        if ($request->isMethod('POST'))
		{
            $objService->bind($request);           
            if ($objService->isValid())
            {
                $oService->setCompany($entity);   //put it after putting foreign ke                
                $em->persist($oService);                
                $em->flush();                
                $session = $request->getSession();             
                $session->getFlashBag()->add('success', 'Record updated successfully');
                return $this->redirect($this->generateUrl('medical_company_addedit', array('id' => $snIdCompany)));
            }            
        }
    }
    
	/**
     * function experienceAction
     *	
	 * @param object $request request
     *
     * @todo   Action for add/edit experience detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function experienceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdCompany = $request->get('id');        
        if(isset($snIdCompany) && $snIdCompany != '')
            $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);
        $snIdExperience = $request->get('experience_id');
        if(isset($snIdExperience) && $snIdExperience != '')
            $oExperience = $em->getRepository('AdminMedicalBundle:Experience')->find($snIdExperience);
        else
            $oExperience = new Experience();       
        $objExperience = $this->createForm(new ExperienceType($this->container), $oExperience);
        
        if($request->isMethod('POST'))
		{
            $objExperience->bind($request);           
            if ($objExperience->isValid())
            {    
                $oExperience->setCompany($entity);
                $em->persist($oExperience);         
                $em->flush();  
                $session = $request->getSession();
                $session->getFlashBag()->add('success', 'Record updated successfully');
                return $this->redirect($this->generateUrl('medical_company_addedit', array('id' => $snIdCompany)));
            }
        }
    }
    
	/**
     * function DoctorAction
     *
	 * @param object $request request	 
     *
     * @todo   Action for add/edit experience detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function DoctorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdCompany = $request->get('id');
        
        if(isset($snIdCompany) && $snIdCompany != '')
            $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);

        $snIdDoctor = $request->get('doctor_id');
        if(isset($snIdDoctor) && $snIdDoctor != '')
            $oDoctor = $em->getRepository('AdminMedicalBundle:Doctor')->find($snIdDoctor);
        else
            $oDoctor = new Doctor();       
        $objDoctor = $this->createForm(new DoctorType($this->container), $oDoctor);
        
        if($request->isMethod('POST')) 
		{
			$objDoctor->bind($request);			   
			if ($objDoctor->isValid()) 
			{    
				$oDoctor->setCompany($entity);   //put it after putting foreign ke
				$em->persist($oDoctor);                
				$em->flush();                
				$session = $request->getSession();               
				$session->getFlashBag()->add('success', 'Record updated successfully');
				return $this->redirect($this->generateUrl('medical_company_addedit', array('id' => $snIdCompany)));
			}            
		}
	}
    
	/**
     * function companyrequestAction
     *	
	 * @param object $request request
     *
     * @todo   Action for add/edit experience detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function companyrequestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $asComanyRequestData = $em->getRepository('AdminMedicalBundle:UserCompanyRequest')->findAll();
        return $this->render('AdminMedicalBundle:Company:companyrequest.html.twig', array( 'asComanyRequestData'      => $asComanyRequestData));
    }
    
	/**
     * function removeCompanyImages
     *	
	 * @param integer $snIdCompany companyid
	 * @param object  $em          entity manager  
	 * @param object  $entity      entity
	 * @param string  $ssType      usertype
     *
     * @todo   function for remove image.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function removeCompanyImages($snIdCompany, $em, $entity, $ssType='company') 
    {
        $targetPath = $this->container->getParameter('web_path').$ssType.'/'.$snIdCompany;		
        if(is_dir($targetPath))
        {
            $TempFolderPath = $targetPath.'/temp_delete';
            if(is_dir($TempFolderPath))
            {
                $files = scandir($TempFolderPath);
                if ( false!==$files ) {
					foreach ( $files as $file ) {
						if( '.'!=$file && '..'!=$file) {           
							$ssFileName = $targetPath.'/'.$file;                    
							if($ssType == 'company')
								$em->getRepository('AdminMedicalBundle:CompanyImages')->deleteData($snIdCompany, $file);
							else
								$em->getRepository('AdminMedicalBundle:SpecialofferImages')->deleteData($snIdCompany, $file);
							unlink($ssFileName);                                         
						}
					}
                }
				$this->deleteDirectory($TempFolderPath);
            }
        }
    }
	
	/**
     * function uploadCompanyImages
     *	
	 * @param integer $snIdCompany companyid
	 * @param object  $em          entity manager  
	 * @param object  $entity      entity
	 * @param string  $ssType      usertype
     *
     * @todo   function for remove image.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function uploadCompanyImages($snIdCompany, $em, $entity, $ssType='company')
    {
        $targetPath = $this->container->getParameter('web_path').$ssType.'/';
		
        if(!is_dir($targetPath))
            mkdir ($targetPath, 0777);
        
        $tempDirPath = $targetPath.'temp';
        if(!is_dir($tempDirPath))
            mkdir ($tempDirPath, 0777);
        
        if(is_dir($targetPath))
        {
            $ssCompanyDir = $targetPath.$snIdCompany;
            if(!is_dir($ssCompanyDir))
            mkdir ($ssCompanyDir, 0777);

            $files = scandir($tempDirPath);
            if ( false!==$files ) {
            foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {                
                $ssFileName = $tempDirPath.'/'.$file;                        
                $ssCompanyPath = $ssCompanyDir.'/'.$file;
				copy($ssFileName, $ssCompanyPath);
				if($ssType == 'company')
					$em->getRepository('AdminMedicalBundle:CompanyImages')->saveData($snIdCompany, $file, $entity);
				else
				{
					$ssCompressImg = $this->container->getParameter('web_path').'coupon_images/';					
					if(!is_dir($ssCompressImg))
						mkdir($ssCompressImg, 0777);
					$ssCouponDir = $ssCompressImg.$snIdCompany;
					if(!is_dir($ssCouponDir))
						mkdir ($ssCouponDir, 0777);
						
					$ssCompressFilePathImg = $ssCouponDir.'/'.$file;
					$this->compress_image($ssCompanyPath, $ssCompressFilePathImg, 15);
					$em->getRepository('AdminMedicalBundle:SpecialofferImages')->saveData($file, $entity);
                }                                                        
            }
            }
            }
            $this->deleteDirectory($tempDirPath);
        }
    }
    
	/**
     * function deleteDirectory
     *	
	 * @param string $dir path	 
     *
     * @todo   function for delete directory.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function deleteDirectory($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) 
        {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir); 
    }
    
    /**
     * function deleteAction
     *	
	 * @param object $request request	 
     *
     * @todo   Action for delete company.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function deleteAction(Request $request)
    {
        if($request->isMethod('POST')) 
		{
			$asCompanyIds = $request->request->all();
			$snCompanyIds = implode(',', $asCompanyIds['chk_delete']);			
			$em = $this->getDoctrine()->getManager();
			$ssFlag = $em->getRepository('AdminMedicalBundle:Company')->deleteData($snCompanyIds);			
			if($ssFlag)
			{	
				if(count($asCompanyIds['chk_delete']) > 0)
				{
					foreach($asCompanyIds['chk_delete'] as $snKey=>$snValue)
					{
						$targetPath = $this->container->getParameter('web_path').'company/'.$snValue;
						$this->deleteDirectory($targetPath);
					}
				}
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'Record deleted successfully');				
				return $this->redirect($this->generateUrl('medical_company'));
			}           
		}
	}
	
	/**
     * function deletespecialofferAction
     *	
	 * @param object $request request	 
     *
     * @todo   Action for delete specialoffer.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function deletespecialofferAction(Request $request)
    {
		$snIdCompany = $request->get('id');
        if ($request->isMethod('POST')) 
		{
			$asOfferIds = $request->request->all();
			$snOfferIds = implode(',', $asOfferIds['chk_delete']);			
			$em = $this->getDoctrine()->getManager();
			$ssFlag = $em->getRepository('AdminMedicalBundle:SpecialOffers')->deleteData($snOfferIds);
			if($ssFlag)
			{
				if(count($asOfferIds['chk_delete']) > 0)
				{
					foreach($asOfferIds['chk_delete'] as $snKey=>$snValue)
					{
						$targetPath = $this->container->getParameter('web_path').'specialoffer/'.$snValue;
						$this->deleteDirectory($targetPath);
					}
				}
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'Record deleted successfully');
				return $this->redirect($this->generateUrl('medical_company_addedit',array('id' => $snIdCompany)));
			}           
		}
	}
	
	/**
     * function deleteratingAction
     *	
	 * @param object $request request	 
     *
     * @todo   Action for delete rating.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function deleteratingAction(Request $request)
    {
		$snIdCompany = $request->get('id');
        if ($request->isMethod('POST')) 
		{
			$asIds = $request->request->all();
			$asIds = implode(',', $asIds['chk_delete']);
			
			$em = $this->getDoctrine()->getManager();
			$ssFlag = $em->getRepository('AdminMedicalBundle:Ratings')->deleteData($asIds);
			if($ssFlag)
			{
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'Record deleted successfully');				
				return $this->redirect($this->generateUrl('medical_company_addedit',array('id' => $snIdCompany, 'ssBooleanFlag' => 1 )));
			}           
		}
	}
	
	/**
     * function verifyuserAction
     *	
	 * @param object $request request	 
     *
     * @todo   Action for verify user rating.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function verifyuserAction(Request $request)
	{
		$snIdRate = $request->get('id');
		$snIdCompany = $request->get('id_company');
		if ($request->isMethod('POST')) 
		{
			$em = $this->getDoctrine()->getManager();
			$ssFlag = $em->getRepository('AdminMedicalBundle:Ratings')->updateData($snIdRate);
			if($ssFlag)
			{
				$asRatingData = $em->getRepository('AdminMedicalBundle:Ratings')->getRatingDetail($snIdCompany);
				$session = $request->getSession();
				$session->getFlashBag()->add('success', 'User verified successfully');
				return $this->render('AdminMedicalBundle:Company:ratelisting.html.twig', array('asRatingData' => $asRatingData, 'snConpanyId' => $snIdCompany));
			}
		}
	}
	
	/**
     * function pricesAction
     *	
	 * @param object $request request	 
     *
     * @todo   Action for add/edit price detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	public function pricesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $snIdCompany = $request->get('id');        
        if(isset($snIdCompany) && $snIdCompany != '')
            $entity = $em->getRepository('AdminMedicalBundle:Company')->find($snIdCompany);
        $snIdPrice = $request->get('price_id');
        if(isset($snIdPrice) && $snIdPrice != '')
            $oPrice = $em->getRepository('AdminMedicalBundle:Prices')->find($snIdPrice);
        else
            $oPrice = new Prices();       
        $objPrice = $this->createForm(new PricesType($this->container), $oPrice);
        
        if($request->isMethod('POST')) 
		{
            $objPrice->bind($request);           
            if($objPrice->isValid())
            {    
                $oPrice->setCompany($entity);
                $em->persist($oPrice);                
                $em->flush();                
                $session = $request->getSession();             
                $session->getFlashBag()->add('success', 'Record updated successfully');
                return $this->redirect($this->generateUrl('medical_company_addedit', array('id' => $snIdCompany)));
            }            
        }
    }
	
	/**
     * function specialofferimageuploadAction
     *	
	 * @param object $request request	 
     *
     * @todo   Action for upload images of special offer.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function specialofferimageuploadAction(Request $request)
    {
        $targetPath = $this->container->getParameter('web_path').'specialoffer/';
        if($request->isXmlHttpRequest() && !empty($_FILES)) 
        {
            if(!is_dir($targetPath))
                mkdir ($targetPath, 0777);
            $tempDirPath = $targetPath.'temp/';
            if(!is_dir($tempDirPath))
                mkdir ($tempDirPath, 0777);            
            $tempFile = $_FILES['file']['tmp_name'];
            $ssFileName = $_FILES['file']['name'];            
            $asFilesData = explode('.', $ssFileName);
            $ssOriginalFileName = uniqid().'.'.$asFilesData[1];
            $targetFile =  $tempDirPath. $ssOriginalFileName;
            move_uploaded_file($tempFile,$targetFile);
            echo "success";
            exit;
        }
        elseif($request->isXmlHttpRequest())
        {
            $result  = array();            
            $storeFolder = $targetPath.$request->get('id');
            if(is_dir($storeFolder))
            {
                $files = scandir($storeFolder);
                if ( false!==$files ) {
                    foreach ( $files as $file ) {
                        if ( '.'!=$file && '..'!=$file) {                           
                            $obj['name'] = $file;
                            $obj['size'] = filesize($storeFolder.'/'.$file);
                            $result[] = $obj;
                        }
                        }
                    }
                header('Content-type: text/json');
                header('Content-type: application/json');
                echo json_encode($result);
                exit;
            }
            else
            {
                $result[] = array("msg"=>"No images");
                echo json_encode($result);;
                exit;
            }
        }
    }
    
    /**
     * function specialofferremoveimageAction
     *	
	 * @param object $request request	 
     *
     * @todo   Action for remove images of special offer.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
    public function specialofferremoveimageAction(Request $request)
    { 
        $targetPath = $this->container->getParameter('web_path').'specialoffer/';        
        if($request->isXmlHttpRequest() && $request->get('name') != '' && $request->get('special_id') != '')
        {
            $snSpecialId = $request->get('special_id');
            $ssFileName = $request->get('name');
            $ssSourcePath = $targetPath.$snSpecialId.'/';
            $ssDestinationPath = $ssSourcePath.'temp_delete/';
            if(!is_dir($ssDestinationPath))
                mkdir($ssDestinationPath, 0777);            
            copy($ssSourcePath.$ssFileName, $ssDestinationPath.$ssFileName);
            echo "success";exit;
        }
        echo "";exit;
    }
	
	/**
     * function compress_image
     *	
	 * @param object $request request	 
     *
     * @todo   function for compress image of special offer.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return 
     */
	function compress_image($src, $dest , $quality)
	{
		$info = getimagesize($src);	  
		if($info['mime'] == 'image/jpeg')
		{
			$image = imagecreatefromjpeg($src);
		}
		elseif($info['mime'] == 'image/gif')
		{
			$image = imagecreatefromgif($src);
		}
		elseif($info['mime'] == 'image/png')
		{
			$image = imagecreatefrompng($src);
		}
		else
		{
			die('Unknown image file format');
		}	  
		//compress and save file to jpg
		imagejpeg($image, $dest, $quality);	  
		//return destination file
		return $dest;
	}
}