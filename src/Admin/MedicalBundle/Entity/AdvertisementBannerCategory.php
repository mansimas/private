<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdvertisementBannerCategory
 */
class AdvertisementBannerCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $test;


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
     * Set test
     *
     * @param string $test
     * @return AdvertisementBannerCategory
     */
    public function setTest($test)
    {
        $this->test = $test;
    
        return $this;
    }

    /**
     * Get test
     *
     * @return string 
     */
    public function getTest()
    {
        return $this->test;
    }
    /**
     * @var \Admin\MedicalBundle\Entity\AdvertiseBanner
     */
    private $banner;

    /**
     * @var \Admin\MedicalBundle\Entity\Category
     */
    private $categories;

    /**
     * @var \Admin\MedicalBundle\Entity\Category
     */
    private $roots;


    /**
     * Set banner
     *
     * @param \Admin\MedicalBundle\Entity\AdvertiseBanner $banner
     * @return AdvertisementBannerCategory
     */
    public function setBanner(\Admin\MedicalBundle\Entity\AdvertiseBanner $banner = null)
    {
        $this->banner = $banner;
    
        return $this;
    }

    /**
     * Get banner
     *
     * @return \Admin\MedicalBundle\Entity\AdvertiseBanner 
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set categories
     *
     * @param \Admin\MedicalBundle\Entity\Category $categories
     * @return AdvertisementBannerCategory
     */
    public function setCategories(\Admin\MedicalBundle\Entity\Category $categories = null)
    {
        $this->categories = $categories;
    
        return $this;
    }

    /**
     * Get categories
     *
     * @return \Admin\MedicalBundle\Entity\Category 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set roots
     *
     * @param \Admin\MedicalBundle\Entity\Category $roots
     * @return AdvertisementBannerCategory
     */
    public function setRoots(\Admin\MedicalBundle\Entity\Category $roots = null)
    {
        $this->roots = $roots;
    
        return $this;
    }

    /**
     * Get roots
     *
     * @return \Admin\MedicalBundle\Entity\Category 
     */
    public function getRoots()
    {
        return $this->roots;
    }
}