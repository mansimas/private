<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Service
 */
class Service
{
    use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
    
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $description;


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
     * Set description
     *
     * @param string $description
     * @return Service
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
    protected $translations;

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
     * @param \Admin\MedicalBundle\Entity\Servicetranslation $translations
     * @return Service
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Servicetranslation $translations)
    {
        $this->translations[] = $translations;
        $translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Servicetranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Servicetranslation $translations)
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
     * @var \Admin\MedicalBundle\Entity\Company
     */
    private $company;


    /**
     * Set company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return Service
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
     * @return Service
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
     * @return Service
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
}