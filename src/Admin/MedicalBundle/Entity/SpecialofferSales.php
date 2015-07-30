<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialofferSales
 */
class SpecialofferSales
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;


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
     * Set email
     *
     * @param string $email
     * @return SpecialofferSales
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
     * @var integer
     */
    private $phone;

    /**
     * @var integer
     */
    private $number_of_coupon;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Admin\MedicalBundle\Entity\SpecialOffers
     */
    private $specialoffers;


    /**
     * Set phone
     *
     * @param integer $phone
     * @return SpecialofferSales
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
     * Set number_of_coupon
     *
     * @param integer $numberOfCoupon
     * @return SpecialofferSales
     */
    public function setNumberOfCoupon($numberOfCoupon)
    {
        $this->number_of_coupon = $numberOfCoupon;
    
        return $this;
    }

    /**
     * Get number_of_coupon
     *
     * @return integer 
     */
    public function getNumberOfCoupon()
    {
        return $this->number_of_coupon;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return SpecialofferSales
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
     * @return SpecialofferSales
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
     * Set specialoffers
     *
     * @param \Admin\MedicalBundle\Entity\SpecialOffers $specialoffers
     * @return SpecialofferSales
     */
    public function setSpecialoffers(\Admin\MedicalBundle\Entity\SpecialOffers $specialoffers = null)
    {
        $this->specialoffers = $specialoffers;
    
        return $this;
    }

    /**
     * Get specialoffers
     *
     * @return \Admin\MedicalBundle\Entity\SpecialOffers 
     */
    public function getSpecialoffers()
    {
        return $this->specialoffers;
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
    private $paypal_transaction_id;

    /**
     * @var string
     */
    private $paypal_payment_status;


    /**
     * Set paypal_transaction_id
     *
     * @param string $paypalTransactionId
     * @return SpecialofferSales
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
     * @return SpecialofferSales
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
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return SpecialofferSales
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $couponcodes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->couponcodes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add couponcodes
     *
     * @param \Admin\MedicalBundle\Entity\SpecialCouponCodes $couponcodes
     * @return SpecialofferSales
     */
    public function addCouponcode(\Admin\MedicalBundle\Entity\SpecialCouponCodes $couponcodes)
    {
        $this->couponcodes[] = $couponcodes;
    
        return $this;
    }

    /**
     * Remove couponcodes
     *
     * @param \Admin\MedicalBundle\Entity\SpecialCouponCodes $couponcodes
     */
    public function removeCouponcode(\Admin\MedicalBundle\Entity\SpecialCouponCodes $couponcodes)
    {
        $this->couponcodes->removeElement($couponcodes);
    }

    /**
     * Get couponcodes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCouponcodes()
    {
        return $this->couponcodes;
    }
    /**
     * @var string
     */
    private $checked_by_admin;


    /**
     * Set checked_by_admin
     *
     * @param string $checkedByAdmin
     * @return SpecialofferSales
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
}