<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\MedicalBundle\Entity\News;
use Admin\MedicalBundle\Form\NewsType;
use Symfony\Component\HttpFoundation\Session\Session;

class NewsController extends Controller
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
        $asNewsData = $em->getRepository('AdminMedicalBundle:News')->getAllNewsDetail();
        return $this->render('AdminMedicalBundle:News:index.html.twig', array('asNewsData' => $asNewsData));
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
        $snIdNews = $request->get('id');
        $objDataNews = "";
        if(isset($snIdNews) && $snIdNews != '')
        {
            $objNews = $em->getRepository('AdminMedicalBundle:News')->find($snIdNews);
            $ssDbFileName = $objNews->getPhoto();
        }
        else
		{
			$objNews = new News();
		}
        $form   = $this->createForm(new NewsType($this->container), $objNews);
        if ($request->isMethod('POST')) 
		{
            $form->bind($request);            
            if ($form->isValid()) 
            {
                $asData = $request->files->get('admin_medicalbundle_news');                
                if(is_array($asData) && $asData['photo'] != '')
                {
                    $ssFolderPath = $this->container->getParameter('web_path').'news/';
                    if(!is_dir($ssFolderPath))
                        mkdir($ssFolderPath, 0777);
                    $ssFilename = $asData['photo']->getClientOriginalName();
                    $asFilesData = explode('.', $ssFilename);                
                    $ssOriginalFileName = uniqid().'.'.$asFilesData[1];
                    $ssTempFilePath = $asData['photo']->getPathName();
                    $ssImagePath = $ssFolderPath.$ssOriginalFileName;
                    move_uploaded_file($ssTempFilePath, $ssImagePath);
                    if(isset($snIdNews) && $snIdNews != '')
                    {
                       $objNews =  $objNews->setPhoto($ssOriginalFileName);
                       $ssNewFileName = $objNews->getPhoto();
                       $ssOldFilePath = $ssFolderPath.$ssDbFileName;
                       /* delete old file*/
                       if(isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath))
                       {
                           unlink($ssOldFilePath);
                       }
                    }
                    else                    
                       $objNews->setPhoto($ssOriginalFileName); 
                }
                else
				{
                    if(isset($snIdNews) && $snIdNews != '')
                    {
                        $objNews->setPhoto($ssDbFileName); 
                    }
                }
                $em->persist($objNews);                
                $em->flush();               
                $session = $request->getSession();
                if(isset($snIdNews) && $snIdNews != '')
                    $session->getFlashBag()->add('success', 'Record updated succesfully');
                else
                    $session->getFlashBag()->add('success', 'Record added succesfully');
                return $this->redirect($this->generateUrl('medical_news'));
            }                     
        }
        return $this->render('AdminMedicalBundle:News:addedit.html.twig', array('form' => $form->createView(),'objNews'=>$objNews));
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
			if(isset($asData['publish']) && $asData['publish'] == 'Publish')
			{
				$ssStatus = "Published";
				$ssFlag = $em->getRepository('AdminMedicalBundle:News')->updateData($asIds, $ssStatus);
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record published succesfully');
				}
			}			
			elseif(isset($asData['unpublish']) && $asData['unpublish'] == 'Unpublish')
			{
				$ssStatus = "Unpublished";
				$ssFlag = $em->getRepository('AdminMedicalBundle:News')->updateData($asIds, $ssStatus);
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record unpublished succesfully');
				}
			}
			elseif(isset($asData['delete']) && $asData['delete'] == 'Delete')
			{
				$asData = $em->getRepository('AdminMedicalBundle:News')->getNewsDetail($asIds);
				if(count($asData) > 0)
				{
					foreach($asData as $snKey=>$ssVal)
					{
						$ssPath = $this->container->getParameter('web_path').'news/'.$ssVal['photo'];				
						if(file_exists($ssPath))
							unlink($ssPath);
					}
				}
				$ssFlag = $em->getRepository('AdminMedicalBundle:News')->deleteData($asIds);
				if($ssFlag)
				{
					$session->getFlashBag()->add('success', 'Record deleted succesfully');
				}
			}
			return $this->redirect($this->generateUrl('medical_news'));
		}
	}
}