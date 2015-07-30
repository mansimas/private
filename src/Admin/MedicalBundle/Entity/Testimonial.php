<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Testimonial
 */
class Testimonial
{
    use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;
   

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
     * Set title
     *
     * @param string $title
     * @return Testimonial
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add translations
     *
     * @param \Admin\MedicalBundle\Entity\Testimonialtranslation $translations
     * @return Testimonial
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Testimonialtranslation $translations)
    {
        $this->translations[] = $translations;
        $translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Testimonialtranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Testimonialtranslation $translations)
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
   
   
    private $url;


    /**
     * Set url
     *
     * @param string $url
     * @return Testimonial
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}