<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ratings
 */
class Ratings
{
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var integer
     */
    private $services;

    /**
     * @var integer
     */
    private $environment;

    /**
     * @var integer
     */
    private $staff;

    /**
     * @var boolean
     */
    private $only_rating;

    /**
     * @var \DateTime
     */
    private $rating_date;

    /**
     * @var boolean
     */
    private $verify_flag;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Admin\MedicalBundle\Entity\Company
     */
    private $company;

    /**
     * @var \Admin\MedicalBundle\Entity\Country
     */
    private $countries;


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
     * @return Ratings
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
     * Set lastname
     *
     * @param string $lastname
     * @return Ratings
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Ratings
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Ratings
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    
        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set services
     *
     * @param integer $services
     * @return Ratings
     */
    public function setServices($services)
    {
        $this->services = $services;
    
        return $this;
    }

    /**
     * Get services
     *
     * @return integer 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set environment
     *
     * @param integer $environment
     * @return Ratings
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    
        return $this;
    }

    /**
     * Get environment
     *
     * @return integer 
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set staff
     *
     * @param integer $staff
     * @return Ratings
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    
        return $this;
    }

    /**
     * Get staff
     *
     * @return integer 
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * Set only_rating
     *
     * @param boolean $onlyRating
     * @return Ratings
     */
    public function setOnlyRating($onlyRating)
    {
        $this->only_rating = $onlyRating;
    
        return $this;
    }

    /**
     * Get only_rating
     *
     * @return boolean 
     */
    public function getOnlyRating()
    {
        return $this->only_rating;
    }

    /**
     * Set rating_date
     *
     * @param \DateTime $ratingDate
     * @return Ratings
     */
    public function setRatingDate($ratingDate)
    {
        $this->rating_date = $ratingDate;
    
        return $this;
    }

    /**
     * Get rating_date
     *
     * @return \DateTime 
     */
    public function getRatingDate()
    {
        return $this->rating_date;
    }

    /**
     * Set verify_flag
     *
     * @param boolean $verifyFlag
     * @return Ratings
     */
    public function setVerifyFlag($verifyFlag)
    {
        $this->verify_flag = $verifyFlag;
    
        return $this;
    }

    /**
     * Get verify_flag
     *
     * @return boolean 
     */
    public function getVerifyFlag()
    {
        return $this->verify_flag;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Ratings
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
     * @return Ratings
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
     * Set company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return Ratings
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
     * Set countries
     *
     * @param \Admin\MedicalBundle\Entity\Country $countries
     * @return Ratings
     */
    public function setCountries(\Admin\MedicalBundle\Entity\Country $countries = null)
    {
        $this->countries = $countries;
    
        return $this;
    }

    /**
     * Get countries
     *
     * @return \Admin\MedicalBundle\Entity\Country 
     */
    public function getCountries()
    {
        return $this->countries;
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