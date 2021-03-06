<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceRepository extends EntityRepository
{
	/**
     * function getServiceDetail
     *
     * @param integer $snCompanyId companyid     
     *
     * @todo   Function get all service detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
    public function getServiceDetail($snCompanyId)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT s.id FROM AdminMedicalBundle:Service s where s.company = '.$snCompanyId.'')            
            ->getArrayResult();        
    }
}