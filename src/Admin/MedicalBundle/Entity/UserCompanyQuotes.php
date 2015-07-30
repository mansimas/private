<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCompanyQuotes
 */
class UserCompanyQuotes
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Admin\MedicalBundle\Entity\Company
     */
    private $company;

    /**
     * @var \Admin\MedicalBundle\Entity\UserQuoteDetail
     */
    private $userquotedetails;


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
     * Set company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return UserCompanyQuotes
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
     * @return UserCompanyQuotes
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
    private $reservation_id;

    /**
     * @var string
     */
    private $resi_address_one;

    /**
     * @var string
     */
    private $resi_address_two;

    /**
     * @var string
     */
    private $resi_city;

    /**
     * @var string
     */
    private $resi_state;

    /**
     * @var string
     */
    private $resi_zip;

    /**
     * @var string
     */
    private $resi_country_id;

    /**
     * @var string
     */
    private $offers;

    /**
     * @var string
     */
    private $specific_wishes;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * Set reservation_id
     *
     * @param string $reservationId
     * @return UserCompanyQuotes
     */
    public function setReservationId($reservationId)
    {
        $this->reservation_id = $reservationId;
    
        return $this;
    }

    /**
     * Get reservation_id
     *
     * @return string 
     */
    public function getReservationId()
    {
        return $this->reservation_id;
    }

    /**
     * Set resi_address_one
     *
     * @param string $resiAddressOne
     * @return UserCompanyQuotes
     */
    public function setResiAddressOne($resiAddressOne)
    {
        $this->resi_address_one = $resiAddressOne;
    
        return $this;
    }

    /**
     * Get resi_address_one
     *
     * @return string 
     */
    public function getResiAddressOne()
    {
        return $this->resi_address_one;
    }

    /**
     * Set resi_address_two
     *
     * @param string $resiAddressTwo
     * @return UserCompanyQuotes
     */
    public function setResiAddressTwo($resiAddressTwo)
    {
        $this->resi_address_two = $resiAddressTwo;
    
        return $this;
    }

    /**
     * Get resi_address_two
     *
     * @return string 
     */
    public function getResiAddressTwo()
    {
        return $this->resi_address_two;
    }

    /**
     * Set resi_city
     *
     * @param string $resiCity
     * @return UserCompanyQuotes
     */
    public function setResiCity($resiCity)
    {
        $this->resi_city = $resiCity;
    
        return $this;
    }

    /**
     * Get resi_city
     *
     * @return string 
     */
    public function getResiCity()
    {
        return $this->resi_city;
    }

    /**
     * Set resi_state
     *
     * @param string $resiState
     * @return UserCompanyQuotes
     */
    public function setResiState($resiState)
    {
        $this->resi_state = $resiState;
    
        return $this;
    }

    /**
     * Get resi_state
     *
     * @return string 
     */
    public function getResiState()
    {
        return $this->resi_state;
    }

    /**
     * Set resi_zip
     *
     * @param string $resiZip
     * @return UserCompanyQuotes
     */
    public function setResiZip($resiZip)
    {
        $this->resi_zip = $resiZip;
    
        return $this;
    }

    /**
     * Get resi_zip
     *
     * @return string 
     */
    public function getResiZip()
    {
        return $this->resi_zip;
    }

    /**
     * Set resi_country_id
     *
     * @param string $resiCountryId
     * @return UserCompanyQuotes
     */
    public function setResiCountryId($resiCountryId)
    {
        $this->resi_country_id = $resiCountryId;
    
        return $this;
    }

    /**
     * Get resi_country_id
     *
     * @return string 
     */
    public function getResiCountryId()
    {
        return $this->resi_country_id;
    }

    /**
     * Set offers
     *
     * @param string $offers
     * @return UserCompanyQuotes
     */
    public function setOffers($offers)
    {
        $this->offers = $offers;
    
        return $this;
    }

    /**
     * Get offers
     *
     * @return string 
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * Set specific_wishes
     *
     * @param string $specificWishes
     * @return UserCompanyQuotes
     */
    public function setSpecificWishes($specificWishes)
    {
        $this->specific_wishes = $specificWishes;
    
        return $this;
    }

    /**
     * Get specific_wishes
     *
     * @return string 
     */
    public function getSpecificWishes()
    {
        return $this->specific_wishes;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return UserCompanyQuotes
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
     * @return UserCompanyQuotes
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
    /**
     * @var boolean
     */
    private $checked_by_admin;


    /**
     * Set checked_by_admin
     *
     * @param boolean $checkedByAdmin
     * @return UserCompanyQuotes
     */
    public function setCheckedByAdmin($checkedByAdmin)
    {
        $this->checked_by_admin = $checkedByAdmin;
    
        return $this;
    }

    /**
     * Get checked_by_admin
     *
     * @return boolean 
     */
    public function getCheckedByAdmin()
    {
        return $this->checked_by_admin;
    }
    /**
     * @var \Admin\MedicalBundle\Entity\Country
     */
    private $countries;


    /**
     * Set countries
     *
     * @param \Admin\MedicalBundle\Entity\Country $countries
     * @return UserCompanyQuotes
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
     * @var string
     */
    private $paypal_transaction_id;

    /**
     * @var string
     */
    private $paypal_payment_status;


    /**
     * Set paypal_transaction_id
     *
     * @param string $paypalTransactionId
     * @return UserCompanyQuotes
     */
    public function setPaypalTransactionId($paypalTransactionId)
    {
        $this->paypal_transaction_id = $paypalTransactionId;
    
        return $this;
    }

    /**
     * Get paypal_transaction_id
     *
     * @return string 
     */
    public function getPaypalTransactionId()
    {
        return $this->paypal_transaction_id;
    }

    /**
     * Set paypal_payment_status
     *
     * @param string $paypalPaymentStatus
     * @return UserCompanyQuotes
     */
    public function setPaypalPaymentStatus($paypalPaymentStatus)
    {
        $this->paypal_payment_status = $paypalPaymentStatus;
    
        return $this;
    }

    /**
     * Get paypal_payment_status
     *
     * @return string 
     */
    public function getPaypalPaymentStatus()
    {
        return $this->paypal_payment_status;
    }
    /**
     * @var string
     */
    private $checked_by_company;


    /**
     * Set checked_by_company
     *
     * @param string $checkedByCompany
     * @return UserCompanyQuotes
     */
    public function setCheckedByCompany($checkedByCompany)
    {
        $this->checked_by_company = $checkedByCompany;
    
        return $this;
    }

    /**
     * Get checked_by_company
     *
     * @return string 
     */
    public function getCheckedByCompany()
    {
        return $this->checked_by_company;
    }
    /**
     * @var string
     */
    private $quote_status;


    /**
     * Set quote_status
     *
     * @param string $quoteStatus
     * @return UserCompanyQuotes
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
     * @var string
     */
    private $unconfirmed_twenty_four_date;


    /**
     * Set unconfirmed_twenty_four_date
     *
     * @param string $unconfirmedTwentyFourDate
     * @return UserCompanyQuotes
     */
    public function setUnconfirmedTwentyFourDate($unconfirmedTwentyFourDate)
    {
        $this->unconfirmed_twenty_four_date = $unconfirmedTwentyFourDate;
    
        return $this;
    }

    /**
     * Get unconfirmed_twenty_four_date
     *
     * @return string 
     */
    public function getUnconfirmedTwentyFourDate()
    {
        return $this->unconfirmed_twenty_four_date;
    }
    /**
     * @var string
     */
    private $sent_unconfirmed_mail;


    /**
     * Set sent_unconfirmed_mail
     *
     * @param string $sentUnconfirmedMail
     * @return UserCompanyQuotes
     */
    public function setSentUnconfirmedMail($sentUnconfirmedMail)
    {
        $this->sent_unconfirmed_mail = $sentUnconfirmedMail;
    
        return $this;
    }

    /**
     * Get sent_unconfirmed_mail
     *
     * @return string 
     */
    public function getSentUnconfirmedMail()
    {
        return $this->sent_unconfirmed_mail;
    }
    /**
     * @var \DateTime
     */
    private $unconfirmed_twenty_four_or_final_reservation_date;

    /**
     * @var string
     */
    private $sent_unconfirmed_or_rating_mail;


    /**
     * Set unconfirmed_twenty_four_or_final_reservation_date
     *
     * @param \DateTime $unconfirmedTwentyFourOrFinalReservationDate
     * @return UserCompanyQuotes
     */
    public function setUnconfirmedTwentyFourOrFinalReservationDate($unconfirmedTwentyFourOrFinalReservationDate)
    {
        $this->unconfirmed_twenty_four_or_final_reservation_date = $unconfirmedTwentyFourOrFinalReservationDate;
    
        return $this;
    }

    /**
     * Get unconfirmed_twenty_four_or_final_reservation_date
     *
     * @return \DateTime 
     */
    public function getUnconfirmedTwentyFourOrFinalReservationDate()
    {
        return $this->unconfirmed_twenty_four_or_final_reservation_date;
    }

    /**
     * Set sent_unconfirmed_or_rating_mail
     *
     * @param string $sentUnconfirmedOrRatingMail
     * @return UserCompanyQuotes
     */
    public function setSentUnconfirmedOrRatingMail($sentUnconfirmedOrRatingMail)
    {
        $this->sent_unconfirmed_or_rating_mail = $sentUnconfirmedOrRatingMail;
    
        return $this;
    }

    /**
     * Get sent_unconfirmed_or_rating_mail
     *
     * @return string 
     */
    public function getSentUnconfirmedOrRatingMail()
    {
        return $this->sent_unconfirmed_or_rating_mail;
    }
    /**
     * @var string
     */
    private $twenty_four_come_final;


    /**
     * Set twenty_four_come_final
     *
     * @param string $twentyFourComeFinal
     * @return UserCompanyQuotes
     */
    public function setTwentyFourComeFinal($twentyFourComeFinal)
    {
        $this->twenty_four_come_final = $twentyFourComeFinal;
    
        return $this;
    }

    /**
     * Get twenty_four_come_final
     *
     * @return string 
     */
    public function getTwentyFourComeFinal()
    {
        return $this->twenty_four_come_final;
    }
    /**
     * @var \DateTime
     */
    private $reservation_date;

    /**
     * @var integer
     */
    private $service_price;


    /**
     * Set reservation_date
     *
     * @param \DateTime $reservationDate
     * @return UserCompanyQuotes
     */
    public function setReservationDate($reservationDate)
    {
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
     * Set service_price
     *
     * @param integer $servicePrice
     * @return UserCompanyQuotes
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
     * @var \DateTime
     */
    private $reservation_time;


    /**
     * Set reservation_time
     *
     * @param \DateTime $reservationTime
     * @return UserCompanyQuotes
     */
    public function setReservationTime($reservationTime)
    {
        $this->reservation_time = $reservationTime;
    
        return $this;
    }

    /**
     * Get reservation_time
     *
     * @return \DateTime 
     */
    public function getReservationTime()
    {
        return $this->reservation_time;
    }
}