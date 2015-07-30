<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
	/**
     * function getNewsDetail
     *
     * @param array $asIds newsids     
     *
     * @todo   Function get newd detail to given ids.
     * @access public
     * @author Arpita Rana <arpita.j.php@gmail.com>
     * @return array
     */
	public function getNewsDetail($asIds)
    {
        return $asData = $this->getEntityManager()
            ->createQuery('SELECT c FROM AdminMedicalBundle:News c where c.id IN ('.$asIds.') ')
            ->getArrayResult();        
    }
	
	/**
     * function deleteData
     *
     * @param array $asIds newsids     
     *
     * @todo   Function to delete news.
     * @access public
     * @author Arpita Rana <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function deleteData($asIds) 
    {
        $asData = $this->getEntityManager()
            ->createQuery('Delete FROM AdminMedicalBundle:News i where i.id IN ('.$asIds.')')
             ->execute();
		return true;
    }
	
	/**
     * function updateData
     *
     * @param array  $asIds    newsids    
	 * @param string $ssStatus status
     *
     * @todo   Function to delete news.
     * @access public
     * @author Arpita Rana <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function updateData($asIds, $ssStatus) 
    {		
        $asData = $this->getEntityManager()
            ->createQuery("UPDATE AdminMedicalBundle:News n SET n.status = '".$ssStatus."' where n.id IN (".$asIds.")")
             ->execute();
		return true;
    }
	
	/**
     * function getLatestNewsDetail
     *
	 * @param string  $ssLocale current culture
	 * @param boolean $ssFlag   flag	 
     *
     * @todo   Function get latest 4 news detail by date.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
    public function getLatestNewsDetail($ssLocale, $ssFlag=false)
    {	
		if($ssFlag)
		{
			$asNewsIds = array();
			$ssLimitQuery = $this->createQueryBuilder('ns')
										->select('ns.id')
										->where('ns.status = :ssStatus')
										->setParameter('ssStatus', 'Published')
										->orderBy('ns.news_date','DESC')
										->setMaxResults(4)
										->getQuery()
										->getArrayResult();
			if(count($ssLimitQuery) > 0)
			{
				foreach($ssLimitQuery as $snKey=>$asVal)
				{
					$asNewsIds[] = $asVal['id'];
				}
			}
			$ssQuery = $this->createQueryBuilder('n')
						->select('n');						
						if(count($asNewsIds) > 0)
						{
							if(count($asNewsIds) > 0)
							$ssQuery->andWhere('n.id IN ('.implode(',',$asNewsIds).')');
						}
			return  $ssQuery->getQuery()					 
					   ->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					   ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
					   ->getArrayResult();
		}
		else
		{
			$ssQuery = $this->createQueryBuilder('n')
						->select('n')
						->where('n.status = :ssStatus')
						->setParameter('ssStatus', 'Published')
						->orderBy('n.news_date','DESC');
						
			return  $ssQuery->getQuery()
					   ->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					   ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
					   ->getArrayResult();
		}
    }
	
	/**
     * function getAllNewsCategoryCompanywiseDetail
     *        
	 * @param string  $ssLocale current culture
	 * @param integer $snId     news id	 
     *
     * @todo   Function get news detail by companywise.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
    public function getAllNewsCategoryCompanywiseDetail($ssLocale, $snId)
    {	
		return $ssQuery = $this->createQueryBuilder('n')
						->select('partial n.{id,news_date,title,description,photo,status,url},partial nc.{id,name}, partial nco.{id,name,address},partial c.{id},partial ct.{id,name},ci')						
						->leftJoin('n.categories', 'nc')						
						->leftJoin('n.company', 'nco')
						->leftJoin('nco.category', 'c')	
						->leftJoin('c.roots', 'ct')						
						->leftJoin('nco.companyimages', 'ci')						
						->where('n.id = :snId')
						->setParameter('snId', $snId)
						->andWhere('n.status = :ssStatus')
						->setParameter('ssStatus', 'Published')
						->getQuery()					 
					    ->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
					    ->getArrayResult();
    }
	
	/**
     * function getAllNewsDetail
     *        
     * @param string  $ssLocale current culture	 
     *
     * @todo   Function get news detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
    public function getAllNewsDetail($ssLocale='en')
    {
		return $ssQuery = $this->createQueryBuilder('n')
						->select('partial n.{id,news_date,title,description,photo,status}')						
						->getQuery()					 
					    ->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
					    ->getArrayResult();
	}
}