<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCompanyRequest
 */
class UserCompanyRequest
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
     * @return UserCompanyRequest
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
    private $lastname;

    /**
     * @var string
     */
    private $email_address;

    /**
     * @var \Admin\MedicalBundle\Entity\Company
     */
    private $company;


    /**
     * Set lastname
     *
     * @param string $lastname
     * @return UserCompanyRequest
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
     * Set email_address
     *
     * @param string $emailAddress
     * @return UserCompanyRequest
     */
    public function setEmailAddress($emailAddress)
    {
        $this->email_address = $emailAddress;
    
        return $this;
    }

    /**
     * Get email_address
     *
     * @return string 
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * Set company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return UserCompanyRequest
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
}