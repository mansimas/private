<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 */
class Country
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ratings;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $companies;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $user_quote_details;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $insurances;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->companies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user_quote_details = new \Doctrine\Common\Collections\ArrayCollection();
        $this->insurances = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Country
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
     * Add ratings
     *
     * @param \Admin\MedicalBundle\Entity\Ratings $ratings
     * @return Country
     */
    public function addRating(\Admin\MedicalBundle\Entity\Ratings $ratings)
    {
        $this->ratings[] = $ratings;
    
        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \Admin\MedicalBundle\Entity\Ratings $ratings
     */
    public function removeRating(\Admin\MedicalBundle\Entity\Ratings $ratings)
    {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Add companies
     *
     * @param \Admin\MedicalBundle\Entity\Company $companies
     * @return Country
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
     * Add user_quote_details
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userQuoteDetails
     * @return Country
     */
    public function addUserQuoteDetail(\Admin\MedicalBundle\Entity\UserQuoteDetail $userQuoteDetails)
    {
        $this->user_quote_details[] = $userQuoteDetails;
    
        return $this;
    }

    /**
     * Remove user_quote_details
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userQuoteDetails
     */
    public function removeUserQuoteDetail(\Admin\MedicalBundle\Entity\UserQuoteDetail $userQuoteDetails)
    {
        $this->user_quote_details->removeElement($userQuoteDetails);
    }

    /**
     * Get user_quote_details
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserQuoteDetails()
    {
        return $this->user_quote_details;
    }

    /**
     * Add insurances
     *
     * @param \Admin\MedicalBundle\Entity\Insurance $insurances
     * @return Country
     */
    public function addInsurance(\Admin\MedicalBundle\Entity\Insurance $insurances)
    {
        $this->insurances[] = $insurances;
    
        return $this;
    }

    /**
     * Remove insurances
     *
     * @param \Admin\MedicalBundle\Entity\Insurance $insurances
     */
    public function removeInsurance(\Admin\MedicalBundle\Entity\Insurance $insurances)
    {
        $this->insurances->removeElement($insurances);
    }

    /**
     * Get insurances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInsurances()
    {
        return $this->insurances;
    }    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usercompanyquotes;


    /**
     * Add usercompanyquotes
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes
     * @return Country
     */
    public function addUsercompanyquote(\Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes)
    {
        $this->usercompanyquotes[] = $usercompanyquotes;
    
        return $this;
    }

    /**
     * Remove usercompanyquotes
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes
     */
    public function removeUsercompanyquote(\Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes)
    {
        $this->usercompanyquotes->removeElement($usercompanyquotes);
    }

    /**
     * Get usercompanyquotes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsercompanyquotes()
    {
        return $this->usercompanyquotes;
    }
}