<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PaymentOptionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaymentOptionRepository extends EntityRepository
{
	/**
     * function deleteData
     *        
     * @param array $asIds payoptionids.	 
     *
     * @todo   Function to delete payment options.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean.
     */
	public function deleteData($asIds) 
    {
        $asData = $this->getEntityManager()
            ->createQuery('Delete FROM AdminMedicalBundle:PaymentOption i where i.id IN ('.$asIds.')')
             ->execute();
		return true;
    }
	
	/**
     * function getPaymentDetail
     *     
     *
     * @todo   Function to get payment detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array.
     */
	public function getPaymentDetail() 
    {
        return $ssQuery = $this->createQueryBuilder('po')
						->select('po.id,po.title')						
						->orderBy('po.id','DESC')
						->getQuery()						
						->getResult();
    }
}