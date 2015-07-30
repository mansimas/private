<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SpecialOffers
 */
class SpecialOffers
{
    use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
    
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $unique_id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;

    /**
     * @var integer
     */
    private $sales_price;

    /**
     * @var integer
     */
    private $contract_num;

    /**
     * @var integer
     */
    private $client_fee;

    /**
     * @var integer
     */
    private $client_fee_percentage;

    /**
     * @var string
     */
    private $other_info;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $introduction;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $translations;

    /**
     * @var \Admin\MedicalBundle\Entity\Company
     */
    private $company;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set unique_id
     *
     * @param string $uniqueId
     * @return SpecialOffers
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
     * Set status
     *
     * @param string $status
     * @return SpecialOffers
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return SpecialOffers
     */
    public function setStartDate($startDate)
    {		
		//$startDate = new \DateTime($startDate);			
		$this->start_date = $startDate;
		
        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
		return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return SpecialOffers
     */
    public function setEndDate($endDate)
    {
		//$endDate = new \DateTime($endDate);		
        $this->end_date = $endDate;
    
        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set sales_price
     *
     * @param integer $salesPrice
     * @return SpecialOffers
     */
    public function setSalesPrice($salesPrice)
    {
        $this->sales_price = $salesPrice;
    
        return $this;
    }

    /**
     * Get sales_price
     *
     * @return integer 
     */
    public function getSalesPrice()
    {
        return $this->sales_price;
    }

    /**
     * Set contract_num
     *
     * @param integer $contractNum
     * @return SpecialOffers
     */
    public function setContractNum($contractNum)
    {
        $this->contract_num = $contractNum;
    
        return $this;
    }

    /**
     * Get contract_num
     *
     * @return integer 
     */
    public function getContractNum()
    {
        return $this->contract_num;
    }

    /**
     * Set client_fee
     *
     * @param integer $clientFee
     * @return SpecialOffers
     */
    public function setClientFee($clientFee)
    {
        $this->client_fee = $clientFee;
    
        return $this;
    }

    /**
     * Get client_fee
     *
     * @return integer 
     */
    public function getClientFee()
    {
        return $this->client_fee;
    }

    /**
     * Set client_fee_percentage
     *
     * @param integer $clientFeePercentage
     * @return SpecialOffers
     */
    public function setClientFeePercentage($clientFeePercentage)
    {
        $this->client_fee_percentage = $clientFeePercentage;
    
        return $this;
    }

    /**
     * Get client_fee_percentage
     *
     * @return integer 
     */
    public function getClientFeePercentage()
    {
        return $this->client_fee_percentage;
    }

    /**
     * Set other_info
     *
     * @param string $otherInfo
     * @return SpecialOffers
     */
    public function setOtherInfo($otherInfo)
    {
        $this->other_info = $otherInfo;
    
        return $this;
    }

    /**
     * Get other_info
     *
     * @return string 
     */
    public function getOtherInfo()
    {
        return $this->other_info;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return SpecialOffers
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set introduction
     *
     * @param string $introduction
     * @return SpecialOffers
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;
    
        return $this;
    }

    /**
     * Get introduction
     *
     * @return string 
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return SpecialOffers
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
     * Add translations
     *
     * @param \Admin\MedicalBundle\Entity\Specialofferstranslation $translations
     * @return SpecialOffers
     *
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Specialofferstranslation $translations)
    {
        $this->translations[] = $translations;
        $translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Specialofferstranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Specialofferstranslation $translations)
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
     * Set company
     *
     * @param \Admin\MedicalBundle\Entity\Company $company
     * @return SpecialOffers
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
    private $start_time;

    /**
     * @var \DateTime
     */
    private $end_time;


    /**
     * Set start_time
     *
     * @param \DateTime $startTime
     * @return SpecialOffers
     */
    public function setStartTime($startTime)
    {
		//$startTime = new \DateTime($startTime);
        $this->start_time = $startTime;
    
        return $this;
    }

    /**
     * Get start_time
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Set end_time
     *
     * @param \DateTime $endTime
     * @return SpecialOffers
     */
    public function setEndTime($endTime)
    {
		//$endTime = new \DateTime($endTime);
        $this->end_time = $endTime;
    
        return $this;
    }

    /**
     * Get end_time
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->end_time;
		//return $endTime = new \DateTime($this->end_time);
    }
    /**
     * @var string
     */
    private $photo;


    /**
     * Set photo
     *
     * @param string $photo
     * @return SpecialOffers
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
     * @return SpecialOffers
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
     * @return SpecialOffers
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
     * @var integer
     */
    private $regular_price;


    /**
     * Set regular_price
     *
     * @param integer $regularPrice
     * @return SpecialOffers
     */
    public function setRegularPrice($regularPrice)
    {
        $this->regular_price = $regularPrice;
    
        return $this;
    }

    /**
     * Get regular_price
     *
     * @return integer 
     */
    public function getRegularPrice()
    {
        return $this->regular_price;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $specialoffersales;


    /**
     * Add specialoffersales
     *
     * @param \Admin\MedicalBundle\Entity\SpecialofferSales $specialoffersales
     * @return SpecialOffers
     */
    public function addSpecialoffersale(\Admin\MedicalBundle\Entity\SpecialofferSales $specialoffersales)
    {
        $this->specialoffersales[] = $specialoffersales;
    
        return $this;
    }

    /**
     * Remove specialoffersales
     *
     * @param \Admin\MedicalBundle\Entity\SpecialofferSales $specialoffersales
     */
    public function removeSpecialoffersale(\Admin\MedicalBundle\Entity\SpecialofferSales $specialoffersales)
    {
        $this->specialoffersales->removeElement($specialoffersales);
    }

    /**
     * Get specialoffersales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpecialoffersales()
    {
        return $this->specialoffersales;
    }
    /**
     * @var boolean
     */
    private $checked_by_admin;


    /**
     * Set checked_by_admin
     *
     * @param boolean $checkedByAdmin
     * @return SpecialOffers
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
     * @var \DateTime
     */
    private $coupon_valid_date;

    /**
     * @var integer
     */
    private $responsible_person;


    /**
     * Set coupon_valid_date
     *
     * @param \DateTime $couponValidDate
     * @return SpecialOffers
     */
    public function setCouponValidDate($couponValidDate)
    {
        $this->coupon_valid_date = $couponValidDate;
    
        return $this;
    }

    /**
     * Get coupon_valid_date
     *
     * @return \DateTime 
     */
    public function getCouponValidDate()
    {
        return $this->coupon_valid_date;
    }

    /**
     * Set responsible_person
     *
     * @param integer $responsiblePerson
     * @return SpecialOffers
     */
    public function setResponsiblePerson($responsiblePerson)
    {
        $this->responsible_person = $responsiblePerson;
    
        return $this;
    }

    /**
     * Get responsible_person
     *
     * @return integer 
     */
    public function getResponsiblePerson()
    {
        return $this->responsible_person;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $couponcodes;


    /**
     * Add couponcodes
     *
     * @param \Admin\MedicalBundle\Entity\SpecialCouponCodes $couponcodes
     * @return SpecialOffers
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $specialofferimages;


    /**
     * Add specialofferimages
     *
     * @param \Admin\MedicalBundle\Entity\SpecialofferImages $specialofferimages
     * @return SpecialOffers
     */
    public function addSpecialofferimage(\Admin\MedicalBundle\Entity\SpecialofferImages $specialofferimages)
    {
        $this->specialofferimages[] = $specialofferimages;
    
        return $this;
    }

    /**
     * Remove specialofferimages
     *
     * @param \Admin\MedicalBundle\Entity\SpecialofferImages $specialofferimages
     */
    public function removeSpecialofferimage(\Admin\MedicalBundle\Entity\SpecialofferImages $specialofferimages)
    {
        $this->specialofferimages->removeElement($specialofferimages);
    }

    /**
     * Get specialofferimages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpecialofferimages()
    {
        return $this->specialofferimages;
    }
    /**
     * @var \DateTime
     */
    private $sale_date;


    /**
     * Set sale_date
     *
     * @param \DateTime $saleDate
     * @return SpecialOffers
     */
    public function setSaleDate($saleDate)
    {
        $this->sale_date = $saleDate;
    
        return $this;
    }

    /**
     * Get sale_date
     *
     * @return \DateTime 
     */
    public function getSaleDate()
    {
        return $this->sale_date;
    }
}