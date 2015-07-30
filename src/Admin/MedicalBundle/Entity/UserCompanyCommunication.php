<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserClinicCommunication
 */
class UserCompanyCommunication
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $user_type;


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
     * Set user_type
     *
     * @param string $userType
     * @return UserClinicCommunication
     */
    public function setUserType($userType)
    {
        $this->user_type = $userType;
    
        return $this;
    }

    /**
     * Get user_type
     *
     * @return string 
     */
    public function getUserType()
    {
        return $this->user_type;
    }
    /**
     * @var \Admin\MedicalBundle\Entity\Company
     */
    private $company;

    /**
     * @var \Admin\MedicalBundle\Entity\UserQuoteDetail
     */
    private $userquotedetails;


    /**
     * Set company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return UserClinicCommunication
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
     * Set userquotedetails
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails
     * @return UserClinicCommunication
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
    /**
     * @var string
     */
    private $reply_message_content;

    /**
     * @var string
     */
    private $service_description;

    /**
     * @var string
     */
    private $brief_service_description;

    /**
     * @var string
     */
    private $responsible_person_doctor;

    /**
     * @var \DateTime
     */
    private $reservation_date;

    /**
     * @var string
     */
    private $reservation_time;

    /**
     * @var integer
     */
    private $service_price;

    /**
     * @var \DateTime
     */
    private $offer_end_date;


    /**
     * Set reply_message_content
     *
     * @param string $replyMessageContent
     * @return UserCompanyCommunication
     */
    public function setReplyMessageContent($replyMessageContent)
    {
        $this->reply_message_content = $replyMessageContent;
    
        return $this;
    }

    /**
     * Get reply_message_content
     *
     * @return string 
     */
    public function getReplyMessageContent()
    {
        return $this->reply_message_content;
    }

    /**
     * Set service_description
     *
     * @param string $serviceDescription
     * @return UserCompanyCommunication
     */
    public function setServiceDescription($serviceDescription)
    {
        $this->service_description = $serviceDescription;
    
        return $this;
    }

    /**
     * Get service_description
     *
     * @return string 
     */
    public function getServiceDescription()
    {
        return $this->service_description;
    }

    /**
     * Set brief_service_description
     *
     * @param string $briefServiceDescription
     * @return UserCompanyCommunication
     */
    public function setBriefServiceDescription($briefServiceDescription)
    {
        $this->brief_service_description = $briefServiceDescription;
    
        return $this;
    }

    /**
     * Get brief_service_description
     *
     * @return string 
     */
    public function getBriefServiceDescription()
    {
        return $this->brief_service_description;
    }

    /**
     * Set responsible_person_doctor
     *
     * @param string $responsiblePersonDoctor
     * @return UserCompanyCommunication
     */
    public function setResponsiblePersonDoctor($responsiblePersonDoctor)
    {
        $this->responsible_person_doctor = $responsiblePersonDoctor;
    
        return $this;
    }

    /**
     * Get responsible_person_doctor
     *
     * @return string 
     */
    public function getResponsiblePersonDoctor()
    {
        return $this->responsible_person_doctor;
    }

    /**
     * Set reservation_date
     *
     * @param \DateTime $reservationDate
     * @return UserCompanyCommunication
     */
    public function setReservationDate($reservationDate)
    {
		//$reservationDate = new \DateTime($reservationDate);		
        $this->reservation_date = $reservationDate;
    
        return $this;
    }

    /**
     * Get reservation_date
     *
     * @return \DateTime 
     */
    public function getReservationDate()
    {
        return $this->reservation_date;
    }

    /**
     * Set reservation_time
     *
     * @param string $reservationTime
     * @return UserCompanyCommunication
     */
    public function setReservationTime($reservationTime)
    {
		//$reservationTime = new \DateTime($reservationTime);		
        $this->reservation_time = $reservationTime;
    
        return $this;
    }

    /**
     * Get reservation_time
     *
     * @return string 
     */
    public function getReservationTime()
    {
        return $this->reservation_time;
    }

    /**
     * Set service_price
     *
     * @param integer $servicePrice
     * @return UserCompanyCommunication
     */
    public function setServicePrice($servicePrice)
    {
        $this->service_price = $servicePrice;
    
        return $this;
    }

    /**
     * Get service_price
     *
     * @return integer 
     */
    public function getServicePrice()
    {
        return $this->service_price;
    }

    /**
     * Set offer_end_date
     *
     * @param \DateTime $offerEndDate
     * @return UserCompanyCommunication
     */
    public function setOfferEndDate($offerEndDate)
    {
		//$offerEndDate = new \DateTime($offerEndDate);
        $this->offer_end_date = $offerEndDate;
    
        return $this;
    }

    /**
     * Get offer_end_date
     *
     * @return \DateTime 
     */
    public function getOfferEndDate()
    {
        return $this->offer_end_date;
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
     * @return UserCompanyCommunication
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
     * @return UserCompanyCommunication
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
	
    public function setCreatedAtValue()
	{
	  if(!$this->getCreatedAt())
	  {
		$this->created_at = new \DateTime();
	  }
	}
	
	public function setUpdatedAtValue()
	{
	  $this->updated_at = new \DateTime();
	}
    /**
     * @var string
     */
    private $company_offered;


    /**
     * Set company_offered
     *
     * @param string $companyOffered
     * @return UserCompanyCommunication
     */
    public function setCompanyOffered($companyOffered)
    {
        $this->company_offered = $companyOffered;
    
        return $this;
    }

    /**
     * Get company_offered
     *
     * @return string 
     */
    public function getCompanyOffered()
    {
        return $this->company_offered;
    }
    /**
     * @var string
     */
    private $checked_by_client;


    /**
     * Set checked_by_client
     *
     * @param string $checkedByClient
     * @return UserCompanyCommunication
     */
    public function setCheckedByClient($checkedByClient)
    {
        $this->checked_by_client = $checkedByClient;
    
        return $this;
    }

    /**
     * Get checked_by_client
     *
     * @return string 
     */
    public function getCheckedByClient()
    {
        return $this->checked_by_client;
    }
    /**
     * @var string
     */
    private $reply_type;


    /**
     * Set reply_type
     *
     * @param string $replyType
     * @return UserCompanyCommunication
     */
    public function setReplyType($replyType)
    {
        $this->reply_type = $replyType;
    
        return $this;
    }

    /**
     * Get reply_type
     *
     * @return string 
     */
    public function getReplyType()
    {
        return $this->reply_type;
    }
    /**
     * @var string
     */
    private $edited_by_admin;


    /**
     * Set edited_by_admin
     *
     * @param string $editedByAdmin
     * @return UserCompanyCommunication
     */
    public function setEditedByAdmin($editedByAdmin)
    {
        $this->edited_by_admin = $editedByAdmin;
    
        return $this;
    }

    /**
     * Get edited_by_admin
     *
     * @return string 
     */
    public function getEditedByAdmin()
    {
        return $this->edited_by_admin;
    }
    /**
     * @var string
     */
    private $company_offered_unique;


    /**
     * Set company_offered_unique
     *
     * @param string $companyOfferedUnique
     * @return UserCompanyCommunication
     */
    public function setCompanyOfferedUnique($companyOfferedUnique)
    {
        $this->company_offered_unique = $companyOfferedUnique;
    
        return $this;
    }

    /**
     * Get company_offered_unique
     *
     * @return string 
     */
    public function getCompanyOfferedUnique()
    {
        return $this->company_offered_unique;
    }
    /**
     * @var string
     */
    private $twenty_four_no_reply;


    /**
     * Set twenty_four_no_reply
     *
     * @param string $twentyFourNoReply
     * @return UserCompanyCommunication
     */
    public function setTwentyFourNoReply($twentyFourNoReply)
    {
        $this->twenty_four_no_reply = $twentyFourNoReply;
    
        return $this;
    }

    /**
     * Get twenty_four_no_reply
     *
     * @return string 
     */
    public function getTwentyFourNoReply()
    {
        return $this->twenty_four_no_reply;
    }
    /**
     * @var string
     */
    private $reservation_type;


    /**
     * Set reservation_type
     *
     * @param string $reservationType
     * @return UserCompanyCommunication
     */
    public function setReservationType($reservationType)
    {
        $this->reservation_type = $reservationType;
    
        return $this;
    }

    /**
     * Get reservation_type
     *
     * @return string 
     */
    public function getReservationType()
    {
        return $this->reservation_type;
    }
}