<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialCouponCodes
 */
class SpecialCouponCodes
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
     * @return SpecialCouponCodes
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
     * @var string
     */
    private $unique_code;

    /**
     * @var \Admin\MedicalBundle\Entity\SpecialofferSales
     */
    private $specialsale;


    /**
     * Set unique_code
     *
     * @param string $uniqueCode
     * @return SpecialCouponCodes
     */
    public function setUniqueCode($uniqueCode)
    {
        $this->unique_code = $uniqueCode;
    
        return $this;
    }

    /**
     * Get unique_code
     *
     * @return string 
     */
    public function getUniqueCode()
    {
        return $this->unique_code;
    }

    /**
     * Set specialsale
     *
     * @param \Admin\MedicalBundle\Entity\SpecialofferSales $specialsale
     * @return SpecialCouponCodes
     */
    public function setSpecialsale(\Admin\MedicalBundle\Entity\SpecialofferSales $specialsale = null)
    {
        $this->specialsale = $specialsale;
    
        return $this;
    }

    /**
     * Get specialsale
     *
     * @return \Admin\MedicalBundle\Entity\SpecialofferSales 
     */
    public function getSpecialsale()
    {
        return $this->specialsale;
    }
    /**
     * @var \Admin\MedicalBundle\Entity\SpecialOffers
     */
    private $specialoffers;


    /**
     * Set specialoffers
     *
     * @param \Admin\MedicalBundle\Entity\SpecialOffers $specialoffers
     * @return SpecialCouponCodes
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
}