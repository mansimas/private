<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DoctorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DoctorRepository extends EntityRepository
{	
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
    public function getAllDoctorsDetail($ssLocale='en')
    {
		return $ssQuery = $this->createQueryBuilder('d')
						->select('partial d.{id,firstname,lastname,photo}')						
						->getQuery()					 
					    ->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
					    ->getArrayResult();
	}	
	
	/**
     * function getAllCategoryInBlock
     *
     * @param string  $ssLocale current culture.	 
     *
     * @todo   Function to get all category in block.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array.
     */
	public function getAllDoctorsInBlock($ssLocale)
	{
		$ssQuery = $this->createQueryBuilder('d')
						->select('d')
						->orderBy('d.firstname','ASC');						                        						
		return $ssQuery->getQuery()
						->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
						->getArrayResult();
	}	
	
	/**
     * function getAllCategoryDetail
     *
     * @param string  $ssLocale     current culture.	 
	 * @param integer $snDoctorId   categoryid.
	 
     *
     * @todo   Function to get all category detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array.
     */
	public function getAllDoctorDetail($ssLocale, $snDoctorId='')
	{
		$ssQuery = $this->createQueryBuilder('d')
						->select('d')
						->where('d.id = :snId')
						->setParameter('snId', $snDoctorId);							
										
		return $ssQuery->orderBy('d.id','DESC')
						->getQuery()
						->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
					    ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $ssLocale)
						->getArrayResult();
	}
	/**
     * function getDoctorsDetail
     *
     * @param array $asIds newsids     
     *
     * @todo   Function get newd detail to given ids.
     * @access public
     * @author Arpita Rana <arpita.j.php@gmail.com>
     * @return array
     */
	public function getDoctorsDetail($asIds)
    {
        return $asData = $this->getEntityManager()
            ->createQuery('SELECT d FROM AdminMedicalBundle:Doctor d where d.id IN ('.$asIds.') ')
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
            ->createQuery('Delete FROM AdminMedicalBundle:Doctor i where i.id IN ('.$asIds.')')
             ->execute();
		return true;
    }
}