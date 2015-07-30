<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserQuoteDetail
 */
class UserQuoteDetail
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $firstname;


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
     * Set firstname
     *
     * @param string $firstname
     * @return UserQuoteDetail
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    /**
     * @var string
     */
    private $middlename;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $quote_status;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $phone;

    /**
     * @var boolean
     */
    private $prefferd_language;

    /**
     * @var boolean
     */
    private $urgent_medical_service;

    /**
     * @var string
     */
    private $health_problem;

    /**
     * @var string
     */
    private $client_IP_address;

    /**
     * @var \Admin\MedicalBundle\Entity\Country
     */
    private $countries;


    /**
     * Set middlename
     *
     * @param string $middlename
     * @return UserQuoteDetail
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
    
        return $this;
    }

    /**
     * Get middlename
     *
     * @return string 
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return UserQuoteDetail
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
     * Set quote_status
     *
     * @param string $quoteStatus
     * @return UserQuoteDetail
     */
    public function setQuoteStatus($quoteStatus)
    {
        $this->quote_status = $quoteStatus;
    
        return $this;
    }

    /**
     * Get quote_status
     *
     * @return string 
     */
    public function getQuoteStatus()
    {
        return $this->quote_status;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return UserQuoteDetail
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
     * Set phone
     *
     * @param integer $phone
     * @return UserQuoteDetail
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set prefferd_language
     *
     * @param boolean $prefferdLanguage
     * @return UserQuoteDetail
     */
    public function setPrefferdLanguage($prefferdLanguage)
    {
        $this->prefferd_language = $prefferdLanguage;
    
        return $this;
    }

    /**
     * Get prefferd_language
     *
     * @return boolean 
     */
    public function getPrefferdLanguage()
    {
        return $this->prefferd_language;
    }

    /**
     * Set urgent_medical_service
     *
     * @param boolean $urgentMedicalService
     * @return UserQuoteDetail
     */
    public function setUrgentMedicalService($urgentMedicalService)
    {
        $this->urgent_medical_service = $urgentMedicalService;
    
        return $this;
    }

    /**
     * Get urgent_medical_service
     *
     * @return boolean 
     */
    public function getUrgentMedicalService()
    {
        return $this->urgent_medical_service;
    }

    /**
     * Set health_problem
     *
     * @param string $healthProblem
     * @return UserQuoteDetail
     */
    public function setHealthProblem($healthProblem)
    {
        $this->health_problem = $healthProblem;
    
        return $this;
    }

    /**
     * Get health_problem
     *
     * @return string 
     */
    public function getHealthProblem()
    {
        return $this->health_problem;
    }

    /**
     * Set client_IP_address
     *
     * @param string $clientIPAddress
     * @return UserQuoteDetail
     */
    public function setClientIPAddress($clientIPAddress)
    {
        $this->client_IP_address = $clientIPAddress;
    
        return $this;
    }

    /**
     * Get client_IP_address
     *
     * @return string 
     */
    public function getClientIPAddress()
    {
        return $this->client_IP_address;
    }

    /**
     * Set countries
     *
     * @param \Admin\MedicalBundle\Entity\Country $countries
     * @return UserQuoteDetail
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     * @return UserQuoteDetail
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
     * @var boolean
     */
    private $read_terms_condition;


    /**
     * Set read_terms_condition
     *
     * @param boolean $readTermsCondition
     * @return UserQuoteDetail
     */
    public function setReadTermsCondition($readTermsCondition)
    {
        $this->read_terms_condition = $readTermsCondition;
    
        return $this;
    }

    /**
     * Get read_terms_condition
     *
     * @return boolean 
     */
    public function getReadTermsCondition()
    {
        return $this->read_terms_condition;
    }
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userquotedocuments;


    /**
     * Add userquotedocuments
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDocuments $userquotedocuments
     * @return UserQuoteDetail
     */
    public function addUserquotedocument(\Admin\MedicalBundle\Entity\UserQuoteDocuments $userquotedocuments)
    {
        $this->userquotedocuments[] = $userquotedocuments;
    
        return $this;
    }

    /**
     * Remove userquotedocuments
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDocuments $userquotedocuments
     */
    public function removeUserquotedocument(\Admin\MedicalBundle\Entity\UserQuoteDocuments $userquotedocuments)
    {
        $this->userquotedocuments->removeElement($userquotedocuments);
    }

    /**
     * Get userquotedocuments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserquotedocuments()
    {
        return $this->userquotedocuments;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usercompanyquotes;


    /**
     * Add usercompanyquotes
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes
     * @return UserQuoteDetail
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
    /**
     * @var string
     */
    private $is_deleted;


    /**
     * Set is_deleted
     *
     * @param string $isDeleted
     * @return UserQuoteDetail
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;
    
        return $this;
    }

    /**
     * Get is_deleted
     *
     * @return string 
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
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
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
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
    /**
     * @var string
     */
    private $unique_id;


    /**
     * Set unique_id
     *
     * @param string $uniqueId
     * @return UserQuoteDetail
     */
    public function setUniqueId($uniqueId)
    {
        $this->unique_id = $uniqueId;
    
        return $this;
    }

    /**
     * Get unique_id
     *
     * @return string 
     */
    public function getUniqueId()
    {
        return $this->unique_id;
    }    

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return UserQuoteDetail
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return UserQuoteDetail
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usercompanycommunication;


    /**
     * Add usercompanycommunication
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication
     * @return UserQuoteDetail
     */
    public function addUsercompanycommunication(\Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication)
    {
        $this->usercompanycommunication[] = $usercompanycommunication;
    
        return $this;
    }

    /**
     * Remove usercompanycommunication
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication
     */
    public function removeUsercompanycommunication(\Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication)
    {
        $this->usercompanycommunication->removeElement($usercompanycommunication);
    }

    /**
     * Get usercompanycommunication
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsercompanycommunication()
    {
        return $this->usercompanycommunication;
    }    
    /**
     * @var string
     */
    private $checked_by_admin;


    /**
     * Set checked_by_admin
     *
     * @param string $checkedByAdmin
     * @return UserQuoteDetail
     */
    public function setCheckedByAdmin($checkedByAdmin)
    {
        $this->checked_by_admin = $checkedByAdmin;
    
        return $this;
    }

    /**
     * Get checked_by_admin
     *
     * @return string 
     */
    public function getCheckedByAdmin()
    {
        return $this->checked_by_admin;
    }

    /**
     * Add categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     * @return UserQuoteDetail
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
}
