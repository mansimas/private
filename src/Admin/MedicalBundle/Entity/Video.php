<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Video
 */
class Video
{
	use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
	
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $youtube_url;


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
     * Set youtube_url
     *
     * @param string $youtubeUrl
     * @return Video
     */
    public function setYoutubeUrl($youtubeUrl)
    {
        $this->youtube_url = $youtubeUrl;
    
        return $this;
    }

    /**
     * Get youtube_url
     *
     * @return string 
     */
    public function getYoutubeUrl()
    {
        return $this->youtube_url;
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Video
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
     * @return Video
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
     * Add translations
     *
     * @param \Admin\MedicalBundle\Entity\Videotranslation $translations
     * @return Video
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Videotranslation $translations)
    {
        $this->translations[] = $translations;
		$translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Videotranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Videotranslation $translations)
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
    private $status;


    /**
     * Set status
     *
     * @param string $status
     * @return Video
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
}