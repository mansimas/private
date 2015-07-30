<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Category
 */
class Category
{
	use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $parent_id;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $lvl;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $news;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userquotedetails;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $companies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userquotedetails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->companies = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set parent_id
     *
     * @param integer $parentId
     * @return Category
     */
    public function setParentId($parentId)
    {
        $this->parent_id = $parentId;
    
        return $this;
    }

    /**
     * Get parent_id
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Category
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    
        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Category
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Category
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    
        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer 
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Category
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Category
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;		
    }

    /**
     * Add translations
     *
     * @param \Admin\MedicalBundle\Entity\Categorytranslation $translations
     * @return Category
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Categorytranslation $translations)
    {
        $this->translations[] = $translations;
		$translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Categorytranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Categorytranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Add news
     *
     * @param \Admin\MedicalBundle\Entity\News $news
     * @return Category
     */
    public function addNew(\Admin\MedicalBundle\Entity\News $news)
    {
        $this->news[] = $news;
    
        return $this;
    }

    /**
     * Remove news
     *
     * @param \Admin\MedicalBundle\Entity\News $news
     */
    public function removeNew(\Admin\MedicalBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Add userquotedetails
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails
     * @return Category
     */
    public function addUserquotedetail(\Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails)
    {
        $this->userquotedetails[] = $userquotedetails;
    
        return $this;
    }

    /**
     * Remove userquotedetails
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails
     */
    public function removeUserquotedetail(\Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails)
    {
        $this->userquotedetails->removeElement($userquotedetails);
    }

    /**
     * Get userquotedetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserquotedetails()
    {
        return $this->userquotedetails;
    }

    /**
     * Add companies
     *
     * @param \Admin\MedicalBundle\Entity\Company $companies
     * @return Category
     */
    public function addCompanie(\Admin\MedicalBundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;
    
        return $this;
    }

    /**
     * Remove companies
     *
     * @param \Admin\MedicalBundle\Entity\Company $companies
     */
    public function removeCompanie(\Admin\MedicalBundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompanies()
    {
        return $this->companies;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
    }
    /**
     * @var integer
     */
    private $root_id;


    /**
     * Set root_id
     *
     * @param integer $rootId
     * @return Category
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $category;


    /**
     * Add category
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $category
     * @return Category
     */
    public function addCategory(\Admin\MedicalBundle\Entity\CompanyCategory $category)
    {
        $this->category[] = $category;
    
        return $this;
    }

    /**
     * Remove category
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $category
     */
    public function removeCategory(\Admin\MedicalBundle\Entity\CompanyCategory $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @var string
     */
    private $status;


    /**
     * Set status
     *
     * @param string $status
     * @return Category
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $root;


    /**
     * Add root
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $root
     * @return Category
     */
    public function addRoot(\Admin\MedicalBundle\Entity\CompanyCategory $root)
    {
        $this->root[] = $root;
    
        return $this;
    }

    /**
     * Remove root
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $root
     */
    public function removeRoot(\Admin\MedicalBundle\Entity\CompanyCategory $root)
    {
        $this->root->removeElement($root);
    }

    /**
     * Get root
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoot()
    {
        return $this->root;
    }   
    /**
     * @var string
     */
    private $metadescription;


    /**
     * Set metadescription
     *
     * @param string $metadescription
     * @return Category
     */
    public function setMetadescription($metadescription)
    {
        $this->metadescription = $metadescription;
    
        return $this;
    }

    /**
     * Get metadescription
     *
     * @return string 
     */
    public function getMetadescription()
    {
        return $this->metadescription;
    }
}