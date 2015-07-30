<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * News
 */
class News
{
    use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $descrption;


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
     * Set title
     *
     * @param string $title
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set descrption
     *
     * @param string $descrption
     * @return News
     */
    public function setDescrption($descrption)
    {
        $this->descrption = $descrption;
    
        return $this;
    }

    /**
     * Get descrption
     *
     * @return string 
     */
    public function getDescrption()
    {
        return $this->descrption;
    }
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return News
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add translations
     *
     * @param \Admin\MedicalBundle\Entity\Newstranslation $translations
     * @return News
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Newstranslation $translations)
    {
        $this->translations[] = $translations;
        $translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Newstranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Newstranslation $translations)
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
     * @var string
     */
    private $photo;


    /**
     * Set photo
     *
     * @param string $photo
     * @return News
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
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $news_date;

    /**
     * @var string
     */
    private $url;


    /**
     * Set status
     *
     * @param string $status
     * @return News
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
     * Set news_date
     *
     * @param \DateTime $newsDate
     * @return News
     */
    public function setNewsDate($newsDate)
    {
		//$newsDate = new \DateTime($newsDate);	
        $this->news_date = $newsDate;
    
        return $this;
    }

    /**
     * Get news_date
     *
     * @return \DateTime 
     */
    public function getNewsDate()
    {
        return $this->news_date;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return News
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;
    

    /**
     * Add categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     * @return News
     */
    public function addCategory(\Admin\MedicalBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     */
    public function removeCategory(\Admin\MedicalBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return News
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
     * @return News
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
     * Add categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     * @return News
     */
    public function addCategorie(\Admin\MedicalBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     */
    public function removeCategorie(\Admin\MedicalBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
         if(!$this->getCreatedAt())
		{
			$this->created_at = new \DateTime();
		}
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $company;


    /**
     * Add company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return News
     */
    public function addCompany(\Admin\MedicalBundle\Entity\Company $company)
    {
        $this->company[] = $company;
    
        return $this;
    }

    /**
     * Remove company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     */
    public function removeCompany(\Admin\MedicalBundle\Entity\Company $company)
    {
        $this->company->removeElement($company);
    }

    /**
     * Get company
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompany()
    {
        return $this->company;
    }
}