<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CompanyImagesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompanyImagesRepository extends EntityRepository
{
	/**
     * function saveData
     *
     * @param integer $snIdCompany company id
	 * @param string  $ssImageName imagename
	 * @param object  $entity      companyobject
     *
     * @todo   Function to save company wise images
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
     public function saveData($snIdCompany, $ssImageName, $entity) 
     {
        if(!is_numeric($snIdCompany) || $snIdCompany == '' || $ssImageName == '')
            return false;
        
        $objCompany = new CompanyImages();
        
        $objCompany->setCompany($entity);
        $objCompany->setPhoto($ssImageName);
                
        $this->getEntityManager()->persist($objCompany);        
        $this->getEntityManager()->flush();
        return true;
    }
	
	/**
     * function deleteData
     *
     * @param integer $companyId  company id
	 * @param string  $ssFileName filename
     *
     * @todo   Function delete company detail
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function deleteData($companyId, $ssFileName) 
    {	
        return $asData = $this->getEntityManager()
            ->createQuery("Delete FROM AdminMedicalBundle:CompanyImages i where i.company = ".$companyId." and i.photo = '".$ssFileName."' ")
             ->execute();
    }
}
