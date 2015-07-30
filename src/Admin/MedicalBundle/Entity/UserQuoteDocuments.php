<?php

namespace Admin\MedicalBundle\Entity;

//use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * UserQuoteDocuments
 */
class UserQuoteDocuments
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $documents;
	
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
     * Set documents
     *
     * @param string $documents
     * @return UserQuoteDocuments
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    
        return $this;
    }

    /**
     * Get documents
     *
     * @return string 
     */
    public function getDocuments()
    {
        return $this->documents;
    }
    /**
     * @var \Admin\MedicalBundle\Entity\UserQuoteDetail
     */
    private $user_quote_detail;


    /**
     * Set user_quote_detail
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userQuoteDetail
     * @return UserQuoteDocuments
     */
    public function setUserQuoteDetail(\Admin\MedicalBundle\Entity\UserQuoteDetail $userQuoteDetail = null)
    {
        $this->user_quote_detail = $userQuoteDetail;
    
        return $this;
    }

    /**
     * Get user_quote_detail
     *
     * @return \Admin\MedicalBundle\Entity\UserQuoteDetail 
     */
    public function getUserQuoteDetail()
    {
        return $this->user_quote_detail;
    }
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return UserQuoteDocuments
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
     * @var \Admin\MedicalBundle\Entity\UserQuoteDetail
     */
    private $userquotedetails;


    /**
     * Set userquotedetails
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails
     * @return UserQuoteDocuments
     */
    public function setUserquotedetails(\Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails = null)
    {
        $this->userquotedetails = $userquotedetails;
    
        return $this;
    }

    /**
     * Get userquotedetails
     *
     * @return \Admin\MedicalBundle\Entity\UserQuoteDetail 
     */
    public function getUserquotedetails()
    {
        return $this->userquotedetails;
    }
}