<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialofferImages
 */
class SpecialofferImages
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $photo;


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
     * Set photo
     *
     * @param string $photo
     * @return SpecialofferImages
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
     * @var \Admin\MedicalBundle\Entity\SpecialOffers
     */
    private $specialoffers;


    /**
     * Set specialoffers
     *
     * @param \Admin\MedicalBundle\Entity\SpecialOffers $specialoffers
     * @return SpecialofferImages
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