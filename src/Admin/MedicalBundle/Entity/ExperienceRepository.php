<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ExperienceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExperienceRepository extends EntityRepository
{
	/**
     * function getExperienceDetail
     *
     * @param integer $snCompanyId companyid     
     *
     * @todo   Function get experince detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array.
     */
    public function getExperienceDetail($snCompanyId)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT s.id FROM AdminMedicalBundle:Experience s where s.company = '.$snCompanyId.'')
            ->getArrayResult();
    }
}