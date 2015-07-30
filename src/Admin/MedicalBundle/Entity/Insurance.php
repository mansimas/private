<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Insurance
 */
class Insurance
{
	use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
    
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    private $photo;

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
    protected $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $countries;

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
        $this->countries = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Insurance
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
     * @return Insurance
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
     * @return Insurance
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
     * Set photo
     *
     * @param string $photo
     * @return Insurance
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Insurance
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
     * @return Insurance
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
     * @param \Admin\MedicalBundle\Entity\Insurancetranslation $translations
     * @return Insurance
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Insurancetranslation $translations)
    {
        $this->translations[] = $translations;
		$translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Insurancetranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Insurancetranslation $translations)
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
     * Add countries
     *
     * @param \Admin\MedicalBundle\Entity\Country $countries
     * @return Insurance
     */
    public function addCountrie(\Admin\MedicalBundle\Entity\Country $countries)
    {
        $this->countries[] = $countries;
    
        return $this;
    }

    /**
     * Remove countries
     *
     * @param \Admin\MedicalBundle\Entity\Country $countries
     */
    public function removeCountrie(\Admin\MedicalBundle\Entity\Country $countries)
    {
        $this->countries->removeElement($countries);
    }

    /**
     * Get countries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * Add companies
     *
     * @param \Admin\MedicalBundle\Entity\Company $companies
     * @return Insurance
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
}