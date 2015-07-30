<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AdvertisementBannerCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertisementBannerCategoryRepository extends EntityRepository
{
	/**
     * function deleteData
     *
     * @param  array $asIds  bannercategoryids.  
     *
     * @todo   Function to delete banner wise category.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function deleteData($asIds) 
    {
        $asData = $this->getEntityManager()
            ->createQuery('Delete FROM AdminMedicalBundle:AdvertisementBannerCategory cc where cc.id IN ('.$asIds.')')
             ->execute();
		return true;
    }
}