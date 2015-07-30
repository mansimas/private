<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AdvertiseBanner
 */
class AdvertiseBanner
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
     * @return AdvertiseBanner
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
     * @var string
     */
    private $unique_id;

    /**
     * @var string
     */
    private $client;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $position;

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
    private $total_shows;

    /**
     * @var string
     */
    private $photo_height;

    /**
     * @var integer
     */
    private $photo_width;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $flash_file;

    /**
     * @var string
     */
    private $script_detail;


    /**
     * Set unique_id
     *
     * @param string $uniqueId
     * @return AdvertiseBanner
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
     * Set client
     *
     * @param string $client
     * @return AdvertiseBanner
     */
    public function setClient($client)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return string 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return AdvertiseBanner
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AdvertiseBanner
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
     * Set lang
     *
     * @param string $lang
     * @return AdvertiseBanner
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AdvertiseBanner
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
     * Set position
     *
     * @param string $position
     * @return AdvertiseBanner
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return AdvertiseBanner
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
     * @return AdvertiseBanner
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
     * Set total_shows
     *
     * @param integer $totalShows
     * @return AdvertiseBanner
     */
    public function setTotalShows($totalShows)
    {
        $this->total_shows = $totalShows;
    
        return $this;
    }

    /**
     * Get total_shows
     *
     * @return integer 
     */
    public function getTotalShows()
    {
        return $this->total_shows;
    }

    /**
     * Set photo_height
     *
     * @param string $photoHeight
     * @return AdvertiseBanner
     */
    public function setPhotoHeight($photoHeight)
    {
        $this->photo_height = $photoHeight;
    
        return $this;
    }

    /**
     * Get photo_height
     *
     * @return string 
     */
    public function getPhotoHeight()
    {
        return $this->photo_height;
    }

    /**
     * Set photo_width
     *
     * @param integer $photoWidth
     * @return AdvertiseBanner
     */
    public function setPhotoWidth($photoWidth)
    {
        $this->photo_width = $photoWidth;
    
        return $this;
    }

    /**
     * Get photo_width
     *
     * @return integer 
     */
    public function getPhotoWidth()
    {
        return $this->photo_width;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return AdvertiseBanner
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

    /**
     * Set flash_file
     *
     * @param string $flashFile
     * @return AdvertiseBanner
     */
    public function setFlashFile($flashFile)
    {
        $this->flash_file = $flashFile;
    
        return $this;
    }

    /**
     * Get flash_file
     *
     * @return string 
     */
    public function getFlashFile()
    {
        return $this->flash_file;
    }

    /**
     * Set script_detail
     *
     * @param string $scriptDetail
     * @return AdvertiseBanner
     */
    public function setScriptDetail($scriptDetail)
    {
        $this->script_detail = $scriptDetail;
    
        return $this;
    }

    /**
     * Get script_detail
     *
     * @return string 
     */
    public function getScriptDetail()
    {
        return $this->script_detail;
    }
    /**
     * @var boolean
     */
    private $new_window;


    /**
     * Set new_window
     *
     * @param boolean $newWindow
     * @return AdvertiseBanner
     */
    public function setNewWindow($newWindow)
    {
        $this->new_window = $newWindow;
    
        return $this;
    }

    /**
     * Get new_window
     *
     * @return boolean 
     */
    public function getNewWindow()
    {
        return $this->new_window;
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
     * @return AdvertiseBanner
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
     * @return AdvertiseBanner
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
     * @param \Admin\MedicalBundle\Entity\AdvertisementBannerCategory $banners
     * @return AdvertiseBanner
     */
    public function addBanner(\Admin\MedicalBundle\Entity\AdvertisementBannerCategory $banners)
    {
        $this->banners[] = $banners;
    
        return $this;
    }

    /**
     * Remove banners
     *
     * @param \Admin\MedicalBundle\Entity\AdvertisementBannerCategory $banners
     */
    public function removeBanner(\Admin\MedicalBundle\Entity\AdvertisementBannerCategory $banners)
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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $cities;


    /**
     * Add cities
     *
     * @param \Admin\MedicalBundle\Entity\City $cities
     * @return AdvertiseBanner
     */
    public function addCity(\Admin\MedicalBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;
    
        return $this;
    }

    /**
     * Remove cities
     *
     * @param \Admin\MedicalBundle\Entity\City $cities
     */
    public function removeCity(\Admin\MedicalBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCities()
    {
        return $this->cities;
    }
    /**
     * @var integer
     */
    private $current_shows;


    /**
     * Set current_shows
     *
     * @param integer $currentShows
     * @return AdvertiseBanner
     */
    public function setCurrentShows($currentShows)
    {
        $this->current_shows = $currentShows;
    
        return $this;
    }

    /**
     * Get current_shows
     *
     * @return integer 
     */
    public function getCurrentShows()
    {
        return $this->current_shows;
    }

    /**
     * Add cities
     *
     * @param \Admin\MedicalBundle\Entity\City $cities
     * @return AdvertiseBanner
     */
    public function addCitie(\Admin\MedicalBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;
    
        return $this;
    }

    /**
     * Remove cities
     *
     * @param \Admin\MedicalBundle\Entity\City $cities
     */
    public function removeCitie(\Admin\MedicalBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }
}