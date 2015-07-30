<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AdvertiseBannerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertiseBannerRepository extends EntityRepository
{
	/**
     * function getBannerDetail
     *
     * @param array $asIds array of banners ids.
     *
     * @todo   Function get banner detail as given banner ids.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function getBannerDetail($asIds)
    {
        return $asData = $this->getEntityManager()
            ->createQuery('SELECT c FROM AdminMedicalBundle:AdvertiseBanner c where c.id IN ('.$asIds.')')
            ->getArrayResult();        
    }
	
	/**
     * function deleteData
     *
     * @param  array $asIds banner ids.
     *
     * @todo   Function to delete banners to given bannerids.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function deleteData($asIds) 
    {
        return $asData = $this->getEntityManager()
            ->createQuery('Delete FROM AdminMedicalBundle:AdvertiseBanner i where i.id IN ('.$asIds.')')
             ->execute();
    }
	
	/**
     * function getNewsStaicBannersDetail
     *
     * @param string $ssBannerType banner-type 
     *
     * @todo   Function get banners as its given type.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array.
     */
	public function getNewsStaicBannersDetail($ssBannerType='', $lang = 'lt')
    {
		$config = $this->getEntityManager()->getConfiguration();		
		$config->addCustomNumericFunction('RAND', 'DoctrineExtensions\Query\Mysql\Rand');
		
		$snDate = date('Y-m-d');
        $ssQuery = $this->createQueryBuilder('b')
						->addSelect('RAND() as HIDDEN rand, b')										
						->orderBy('rand')						
						->where('b.status= :ssStatus')
						->andWhere('b.start_date <= :sndate')
						->andWhere('b.end_date >= :sndate')
						->andWhere('b.current_shows < b.total_shows')
                        ->andWhere('b.lang = :sslang')
						->setParameter('sndate', $snDate)
						->setParameter('ssStatus', 'active')
                        ->setParameter('sslang', $lang)
						->setMaxResults(2);
						if($ssBannerType != '')
						{
							$ssQuery->andWhere('b.position= :ssBannerType')
							->setParameter('ssBannerType', $ssBannerType);
						}

        return $ssQuery->getQuery()->getArrayResult();
	}
	/**
     * function getAddBannerDetail
     *
     * @param string  $ssBannerType  banner-type
	 * @param integer $snCategoryIds categoryid
	 * @param integer $ssCityId      cityid
	 * @param integer $ssMiddle      cityid
     *
     * @todo   Function get banner detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function getAddBannerDetail($ssBannerType='', $snCategoryIds='', $ssFlag='', $ssCityId='', $ssMiddle='', $lang = 'lt')
    {
		
		$config = $this->getEntityManager()->getConfiguration();		
		$config->addCustomNumericFunction('RAND', 'DoctrineExtensions\Query\Mysql\Rand');
		
		$snDate = date('Y-m-d');
        $ssQuery = $this->createQueryBuilder('b')
						->addSelect('RAND() as HIDDEN rand, b,partial ct.{id},partial ctt.{id,name},partial ts.{id,name}')
						->leftjoin('b.banners','ct')
						->leftjoin('ct.roots','ctt')
						->leftjoin('b.cities','ts')						
						->orderBy('rand')						
						->where('b.status= :ssStatus')
						->andWhere('b.start_date < :sndate')
						->andWhere('b.end_date > :sndate')
						->andWhere('b.current_shows < b.total_shows')
						->andWhere('b.lang = :sslang')
						->setParameter('sndate', $snDate)
						->setParameter('ssStatus', 'active')
                        ->setParameter('sslang', $lang);
						if($ssBannerType != '')
						{
							$ssQuery->andWhere('b.position= :ssBannerType')
							->setParameter('ssBannerType', $ssBannerType);
						}
						if($snCategoryIds != '' && $ssFlag == '' )
						{
							$ssQuery->andWhere('ctt.id IN ('.$snCategoryIds.')');
						}
						if($snCategoryIds != '' && $ssFlag == 1 && $snCategoryIds != 'undefined')
						{
							$ssQuery->andWhere('b.id NOT IN ('.$snCategoryIds.')');
						}
						if($ssCityId != '' && $ssFlag == 1)
						{							
							$ssQuery->andWhere('ts.id IN ('.$ssCityId.')');						
						}
						if($ssMiddle != '' )
						{
							$ssQuery->setMaxResults(1);						
						}
        return $ssQuery->getQuery()->getArrayResult();					  
    }
	
	/**
     * function getDataByBannerId
     *
     * @param string  $ssLocale   locale
	 * @param integer $snBannerId bannnerid	 
     *
     * @todo   Function get banner detail by given id.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function getDataByBannerId($ssLocale,$snBannerId='')
	{	
		$ssQuery = $this->createQueryBuilder('comp')
						->select('partial comp.{id}','ct','partial ctt.{id,name}')
						->leftjoin('comp.banners','ct')
						->leftjoin('ct.categories','ctt')
						->andWhere('comp.id = :snId')

						->setParameter('snId',$snBannerId)						
						->getQuery()
						->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
						->getArrayResult();
		
		$asCategoryDetail = array();
		
		if(count($ssQuery) > 0 && count($ssQuery[0]['banners']) > 0)
		{
			foreach($ssQuery[0]['banners'] as $snKey=>$asVal)
			{
				$asCategoryDetail[$asVal['categories']['id']] = $asVal['categories']['name'];
			}
		}
		return $asCategoryDetail;
	}
	
	/**
     * function updateBannerCount
     *     
	 * @param integer $ssBannerId bannnerid	
     *
     * @todo   Function to update showbanner count.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function updateBannerCount($ssBannerId){
		$ssQuery = $this->createQueryBuilder('b')
						->update()
						->set('b.current_shows', '(b.current_shows + 1)')
						->where('b.id IN ('.$ssBannerId.')')						
						->getQuery()
						->execute();
		return true;
	}
	
	/**
     * function updateBannerStatus
     *
     * @param string $status field name     
     *
     * @todo   Function to update banner status.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function updateBannerStatus()
	{
		$snDate = date('Y-m-d');
		$ssStatu = "stop";
		$ssQuery = $this->createQueryBuilder('b')
						->update()
						->set('b.status', ':ssValue')
						->where('b.end_date < :snDate')
						->setParameter('snDate', $snDate)
						->setParameter('ssValue', $ssStatu)
						->getQuery()
						->execute();
		return true;
	}	
}