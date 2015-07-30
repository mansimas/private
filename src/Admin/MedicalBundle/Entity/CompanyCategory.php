<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyCategory
 */
class CompanyCategory
{
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $root_id;

    /**
     * @var \Admin\MedicalBundle\Entity\Company
     */
    private $company;

    /**
     * @var \Admin\MedicalBundle\Entity\Category
     */
    private $categories;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set root_id
     *
     * @param integer $rootId
     * @return CompanyCategory
     */
    public function setRootId($rootId)
    {
        $this->root_id = $rootId;
    
        return $this;
    }

    /**
     * Get root_id
     *
     * @return integer 
     */
    public function getRootId()
    {
        return $this->root_id;
    }

    /**
     * Set company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return CompanyCategory
     */
    public function setCompany(\Admin\MedicalBundle\Entity\Company $company = null)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return \Admin\MedicalBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     * @return CompanyCategory
     */
    public function setCategories(\Admin\MedicalBundle\Entity\Category $categories = null)
    {
        $this->categories = $categories;
    
        return $this;
    }

    /**
     * Get categories
     *
     * @return \Admin\MedicalBundle\Entity\Category 
     */
    public function getCategories()
    {
        return $this->categories;
    }
    /**
     * @var integer
     */
    private $category_id;


    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return CompanyCategory
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;
    
        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }
    /**
     * @var \Admin\MedicalBundle\Entity\Category
     */
    private $roots;


    /**
     * Set roots
     *
     * @param \Admin\MedicalBundle\Entity\Category $roots
     * @return CompanyCategory
     */
    public function setRoots(\Admin\MedicalBundle\Entity\Category $roots = null)
    {
        $this->roots = $roots;
    
        return $this;
    }

    /**
     * Get roots
     *
     * @return \Admin\MedicalBundle\Entity\Category 
     */
    public function getRoots()
    {
        return $this->roots;
    }
}