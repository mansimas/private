<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 */
class City
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
     * @return City
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
    private $banners;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->banners = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add banners
     *
     * @param \Admin\MedicalBundle\Entity\AdvertiseBanner $banners
     * @return City
     */
    public function addBanner(\Admin\MedicalBundle\Entity\AdvertiseBanner $banners)
    {
        $this->banners[] = $banners;
    
        return $this;
    }

    /**
     * Remove banners
     *
     * @param \Admin\MedicalBundle\Entity\AdvertiseBanner $banners
     */
    public function removeBanner(\Admin\MedicalBundle\Entity\AdvertiseBanner $banners)
    {
        $this->banners->removeElement($banners);
    }

    /**
     * Get banners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBanners()
    {
        return $this->banners;
    }
}