<?php

namespace Admin\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\MedicalBundle\Entity\Category;
use Admin\MedicalBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{

    /**
     * function indexAction
     *
     * @param  object $request request
     *
     * @todo   Action for display video.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $locale = $this->container->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $entities = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryDetail($ssLocale);
        $session = $request->getSession();
        if ($request->get('status') != '') {
            if ($request->get('status') == 'Active') {
                $asData = $em->getRepository('AdminMedicalBundle:Category')->getActiveCatgoryDetails('Active');
                if (is_array($asData) && !empty($asData) && $asData[0]['active_count'] < 9) {
                    $em->getRepository('AdminMedicalBundle:Category')->updateCategoryStatus($request->get('id'), $request->get('status'));
                    $session->getFlashBag()->add('success', 'Category active successfully');
                } else {
                    $session->getFlashBag()->add('error', 'Maximum 9 category you can active');
                }
            } else {
                $em->getRepository('AdminMedicalBundle:Category')->updateCategoryStatus($request->get('id'), $request->get('status'));
                $session->getFlashBag()->add('success', 'Category inactive successfully');
                return $this->redirect($this->generateUrl('medical_category'));
            }
            return $this->redirect($this->generateUrl('medical_category'));
        }
        return $this->render('AdminMedicalBundle:Category:index.html.twig', array('entities' => $entities));
    }

    /**
     * function indexAction
     *
     * @param  object $request request
     *
     * @todo   Action for display video.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createForm(new CategoryType($this->container), $entity);
        $form->bind($request);
        //Category Photo Code
        $asData = $request->files->get('admin_medicalbundle_category');
        if (is_array($asData) && $asData['photo'] != '') {
            $ssFolderPath = $this->container->getParameter('web_path') . 'category/';
            if (!is_dir($ssFolderPath))
                mkdir($ssFolderPath, 0777);
            $ssFilename = $asData['photo']->getClientOriginalName();
            $asFilesData = explode('.', $ssFilename);
            $ssOriginalFileName = uniqid() . '.' . $asFilesData[1];
            $ssTempFilePath = $asData['photo']->getPathName();
            $ssImagePath = $ssFolderPath . $ssOriginalFileName;
            move_uploaded_file($ssTempFilePath, $ssImagePath);
            $entity->setPhoto($ssOriginalFileName);
        }
        $request1 = $request->request->all();
        $categoryObj = $request1['admin_medicalbundle_category'];
        $categoryObj['category'];
        $categoryObj['sub_category'];
        $categoryObj['sub_sub_category'];
        $em = $this->getDoctrine()->getManager();
        if (isset($categoryObj['category']) && isset($categoryObj['sub_category']) && isset($categoryObj['sub_sub_category'])) {
            $parentId = $categoryObj['sub_sub_category'];
        }
        if (isset($categoryObj['category']) && isset($categoryObj['sub_category']) && $categoryObj['sub_sub_category'] == "") {
            $parentId = $categoryObj['sub_category'];
        }
        if (isset($categoryObj['category']) && $categoryObj['sub_category'] == "" && $categoryObj['sub_sub_category'] == "") {
            $parentId = $categoryObj['category'];
        }
        if ($categoryObj['category'] == "" && $categoryObj['sub_category'] == "" && $categoryObj['sub_sub_category'] == "") {
            $parentId = 0;
        }
        if ($parentId != 0) {
            $category = $em->getRepository('AdminMedicalBundle:Category')->find($parentId);
            $selcatLvl = $category->getLvl();
            $selcatLevel = $selcatLvl + 1;
        } else {
            $selcatLevel = 1;
        }
        $mainLocale = 'lt';
        if($categoryObj['translations']['lt']['name'] != '') {
            $mainLocale = 'lt';
        } else if($categoryObj['translations']['en']['name'] != '') {
            $mainLocale = 'en';
        } else if($categoryObj['translations']['ru']['name'] != '') {
            $mainLocale = 'ru';
        } else if($categoryObj['translations']['de']['name'] != '') {
            $mainLocale = 'de';
        }
        $entity->setName($categoryObj['translations'][$mainLocale]['name']);
        $entity->setUrl($categoryObj['translations'][$mainLocale]['url']);
        $entity->setMetadescription($categoryObj['translations'][$mainLocale]['metadescription']);
        $entity->setDescription($categoryObj['translations'][$mainLocale]['description']);
        $entity->setParentId($parentId);
        $entity->setLvl($selcatLevel);
        $entity->setCreatedAt(new \DateTime());
        $entity->setStatus("InActive");
        if ($parentId != 0) {
            $entity->setRootId($category->getRootId());
        }
        $em->persist($entity);
        $em->flush();
        if ($parentId == 0) {
            $category = $em->getRepository('AdminMedicalBundle:Category')->find($entity->getId());
            $category->setRootId($entity->getId());
            $em->persist($category);
            $em->flush();
        }
        $session = $request->getSession();
        $session->start();
        $session->getFlashBag()->add('success', 'Record Created successfully');
        return $this->redirect($this->generateUrl('medical_category'));
    }

    /**
     * function indexAction
     *
     * @param  object $request request
     *
     * @todo   Action for display video.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return Response
     */
    public function newAction()
    {
        $entity = new Category();
        $form = $this->createForm(new CategoryType($this->container), $entity);
        return $this->render('AdminMedicalBundle:Category:new.html.twig', array('entity' => $entity, 'form' => $form->createView()));
    }

    /**
     * function indexAction
     *
     * @param  object $request request
     *
     * @todo   Action for display video.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminMedicalBundle:Category')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('AdminMedicalBundle:Category:show.html.twig', array('entity' => $entity, 'delete_form' => $deleteForm->createView()));
    }

    /**
     * function indexAction
     *
     * @param  object $request request
     *
     * @todo   Action for display video.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        if (isset($id) && $id != '') {
            $entity = $em->getRepository('AdminMedicalBundle:Category')->find($id);
            $ssDbFileName = $entity->getPhoto();
        }
        $snParentId = 0;
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        $editForm = $this->createEditForm($entity);
        return $this->render('AdminMedicalBundle:Category:edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));
    }

    /**
     * function indexAction
     *
     * @param  object $request request
     *
     * @todo   Action for display video.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType($this->container), $entity, array(
            'action' => $this->generateUrl('medical_category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Update'));
        return $form;
    }

    /**
     * function updateAction
     *
     * @param  object $request request
     *
     * @todo   Action for update.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminMedicalBundle:Category')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        $editForm = $this->createForm(new CategoryType($this->container), $entity);
        $catForm = $request->request->get($editForm->getName());
        $asData = $request->files->get('admin_medicalbundle_category');
        $category = $catForm['category'];
        $sbcategory = $catForm['sub_category'];
        $sbsbcategory = $catForm['sub_sub_category'];
        // Upload Image Code
        $ssDbFileName = $entity->getPhoto();
        $ssCategoryStatus = $entity->getStatus();
        $editForm->bind($request);
        if ($id != '') {
            $asData = $request->files->get('admin_medicalbundle_category');
            if (is_array($asData) && $asData['photo'] != '') {
                $ssFolderPath = $this->container->getParameter('web_path') . 'category/';
                if (!is_dir($ssFolderPath))
                    mkdir($ssFolderPath, 0777);
                $ssFilename = $asData['photo']->getClientOriginalName();
                $asFilesData = explode('.', $ssFilename);
                $ssOriginalFileName = uniqid() . '.' . $asFilesData[1];
                $ssTempFilePath = $asData['photo']->getPathName();
                $ssImagePath = $ssFolderPath . $ssOriginalFileName;
                move_uploaded_file($ssTempFilePath, $ssImagePath);
                if (isset($id) && $id != '') {
                    $entity = $entity->setPhoto($ssOriginalFileName);
                    $ssNewFileName = $entity->getPhoto();
                    $ssOldFilePath = $ssFolderPath . $ssDbFileName;
                    /* delete old file */
                    if (isset($ssDbFileName) && $ssDbFileName != $ssNewFileName && file_exists($ssOldFilePath)) {
                        unlink($ssOldFilePath);
                    }
                }
            } else {
                $entity->setPhoto($ssDbFileName);
            }
            $entity->setStatus($ssCategoryStatus);
        } else {
            $editForm->getErrors();
            return $this->render('AdminMedicalBundle:Category:edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));
        }
        // IF CATEGORY, SUB CATEGORY AND SUB OF SUB CATEGORY ARE CHANGED
        if ($sbsbcategory != "" AND $sbcategory != "" AND $category != "") {
            //Current Category Record
            $entity->setParentId($sbsbcategory);
            // Sub of Sub Category Code
            $sbsbcateQry = $em->getRepository('AdminMedicalBundle:Category')->find($sbsbcategory);
            $sbsbcateQry->setParentId($sbcategory);
            $sbsbcateQry->setLvl(3);
            //Sub Category Code
            $sbcateQry = $em->getRepository('AdminMedicalBundle:Category')->find($sbcategory);
            $sbcateQry->setParentId($category);
            $sbcateQry->setLvl(2);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('medical_category'));
        }

        // IF CATEGORY AND SUB CATEGORY ARE CHANGED AND SUB OF SUB CATEGORY IS NULL OR NOT SET
        if ($sbsbcategory == "" AND $sbcategory != "" AND $category != "") {
            //Current Category Record
            $entity->setParentId($sbcategory);
            // Sub Category Code
            $sbcategory = $em->getRepository('AdminMedicalBundle:Category')->find($sbcategory);
            $sbcategory->setParentId($category);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('medical_category'));
        }

        // IF CATEGORY SELECTED AND SUB CATEGORY AND SUB OF SUB CATEGORY IS NULL OR NOT SET
        if ($sbsbcategory == "" AND $sbcategory == "" AND $category != "") {
            //Current Category Record
            $entity->setParentId($category);
            // UPDATE CURRENT RECORD LEVEL AS PER PARENT SELECTED
            $currCatLvl = $em->getRepository('AdminMedicalBundle:Category')->find($category);
            $level = $currCatLvl->getLvl();
            $finalLvl = $level + 1;
            $entity->setLvl($finalLvl);
            //Sub Category Code
            $em->persist($entity);
            $em->flush();
            $session = $request->getSession();
            $session->start();
            $session->getFlashBag()->add('success', 'Record Updated successfully');
            return $this->redirect($this->generateUrl('medical_category'));
        }

        if ($sbsbcategory == "" AND $sbcategory == "" AND $category == "") {
            //Current Category Record
            $parentId = 0;
            $level = 1;
            $entity->setParentId($parentId);
            $entity->setLvl($level);
            $em->persist($entity);
            $em->flush();
            $session = $request->getSession();
            $session->start();
            $session->getFlashBag()->add('success', 'Record Updated successfully');
            return $this->redirect($this->generateUrl('medical_category'));
        }
    }

    /**
     * function deleteAction
     *
     * @param  object $request request
     *
     * @todo   Action for delete.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function deleteAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $asIds = $request->request->all();
            $asIds = implode(',', $asIds['chk_delete']);
            $em = $this->getDoctrine()->getManager();
            $subId = '';
            $entities = $em->getRepository('AdminMedicalBundle:Category')->findBy(array('parent_id' => $asIds));
            foreach ($entities as $entity) {
                $subId[] = $entity->getId();
            }
            if ($subId) {
                $subcatId = implode(',', $subId);
                $files = $em->getRepository('AdminMedicalBundle:Category')->getCatgoryDetails($subcatId);
                if (count($files) > 0) {
                    foreach ($files as $snKey => $ssVal) {
                        $ssPath = $this->container->getParameter('web_path') . 'category/' . $ssVal['photo'];
                        if (file_exists($ssPath))
                            unlink($ssPath);
                    }
                }
                $em->getRepository('AdminMedicalBundle:Category')->deleteData($subcatId);
            }
            $files = $em->getRepository('AdminMedicalBundle:Category')->getCatgoryDetails($asIds);
            if (count($files) > 0) {
                foreach ($files as $snKey => $ssVal) {
                    $ssPath = $this->container->getParameter('web_path') . 'category/' . $ssVal['photo'];
                    if (file_exists($ssPath))
                        unlink($ssPath);
                }
            }
            $ssFlag = $em->getRepository('AdminMedicalBundle:Category')->deleteData($asIds);
            if ($ssFlag || $subId) {
                $session = $request->getSession();
                $session->start();
                $session->getFlashBag()->add('success', 'Record deleted successfully');
                return $this->redirect($this->generateUrl('medical_category'));
            }
        }
    }

    /**
     * function deleteAction
     *
     * @param  object $request request
     *
     * @todo   Action for update.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medical_category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * function fetchAction
     *
     * @param  object $request request
     *
     * @todo   Action for update.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function fetchAction(Request $request)
    {
        $cat_id = $request->get('categorie_id');
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        // for display parent category in search part
        $asSubCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategory($ssLocale, $cat_id);

        $arr2 = array();
        $arr = array();
        foreach ($asSubCategoryData as $r) {
            $arr['id'] = $r['id'];
            $arr['name'] = $r['name'];
            $arr2[] = $arr;
        }
        echo json_encode($arr2);
        exit;
    }

    /**
     * function subfetchAction
     *
     * @param  object $request request
     *
     * @todo   Action for update.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function subfetchAction(Request $request)
    {
        $sub_cat_id = $request->get('sub_categorie_id');
        $locale = $this->get('session')->get('_locale');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $em = $this->getDoctrine()->getManager();
        // for display parent category in search part
        $asSubOfSubCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllSubOfSubCategory($ssLocale, $sub_cat_id);
        $arr2 = array();
        $arr = array();
        foreach ($asSubOfSubCategoryData as $r) {
            $arr['id'] = $r['id'];
            $arr['name'] = $r['name'];
            $arr2[] = $arr;
        }
        echo json_encode($arr2);
        exit;
    }

    /**
     * function subsubfetchAction
     *
     * @param  object $request request
     *
     * @todo   Action for update.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function subsubfetchAction(Request $request)
    {
        $sub_sub_id = $request->get('sub_sub_id');
        $em1 = $this->getDoctrine()->getManager();
        $em = $this->getDoctrine()->getRepository('AdminMedicalBundle:Category');
        $subcatcat_id = $em->findOneById($sub_sub_id);
        $parent_id = $subcatcat_id->getParentId();
        $subcat_id = $em->findOneById($parent_id);
        $sbsb_pid = $subcat_id->getParentId();
        $locale = $this->get('session')->get('_locale');
        if ($locale == '')
            $locale = $this->get('session')->set('_locale', 'en');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        $lvl = 3;
        $em = $this->getDoctrine()->getManager();
        $asSubOfSubCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryWithLevel($ssLocale, $sbsb_pid, $lvl);
        $arr2 = array();
        $arr = array();
        foreach ($asSubOfSubCategoryData as $r) {
            $arr['sel_id'] = $parent_id;
            $arr['id'] = $r['id'];
            $arr['name'] = $r['name'];
            $arr2[] = $arr;
        }
        echo json_encode($arr2);
        exit;
    }

    /**
     * function subcatfetchAction
     *
     * @param  object $request request
     *
     * @todo   Action for update.
     * @access public
     * @author Kunjal Popat <kunjal.p.php@gmail.com>
     * @return
     */
    public function subcatfetchAction(Request $request)
    {
        $sub_cat_id = $request->get('sub_cat_id');
        $em1 = $this->getDoctrine()->getManager();
        $em = $this->getDoctrine()->getRepository('AdminMedicalBundle:Category');
        $subcatcat_id = $em->findOneById($sub_cat_id);
        $maincatId = $subcatcat_id->getParentId();
        $level = $subcatcat_id->getLvl();
        $locale = $this->get('session')->get('_locale');
        if ($locale == '')
            $locale = $this->get('session')->set('_locale', 'en');
        $ssLocale = ((isset($locale) && $locale != '') ? $locale : 'en');
        if ($level == 3 || $level == 4) {
            if ($level == 3) {
                $sbsb_pid1 = $subcatcat_id->getParentId();
                $subcat_id = $em->findOneById($sbsb_pid1);
                $sbsb_pid = $subcat_id->getParentId();
                $em = $this->getDoctrine()->getManager();
                // for display parent category in search part
                $lvl = 2;
                $asSubOfSubCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryWithLevel($ssLocale, $sbsb_pid, $lvl);
                $arr2 = array();
                $arr = array();
            }
            if ($level == 4) {
                $parent_id = $subcatcat_id->getParentId();
                $subcat_id = $em->findOneById($parent_id);
                $sbsb_pid1 = $subcat_id->getParentId();
                $subincat_id = $em->findOneById($sbsb_pid1);
                $sbsb_pid = $subincat_id->getParentId();
                $lvl = 2;
                $em = $this->getDoctrine()->getManager();
                $asSubOfSubCategoryData = $em->getRepository('AdminMedicalBundle:Category')->getAllSubCategoryWithLevel($ssLocale, $sbsb_pid, $lvl);
                $arr2 = array();
                $arr = array();
            }
            foreach ($asSubOfSubCategoryData as $r) {
                $arr['sel_id'] = $sbsb_pid1;
                $arr['main_cat'] = $sbsb_pid;
                $arr['id'] = $r['id'];
                $arr['name'] = $r['name'];
                $arr2[] = $arr;
            }
        } else {
            $arr['main_cat'] = $maincatId;
            $arr2[] = $arr;
        }
        echo json_encode($arr2);
        exit;
    }
}
