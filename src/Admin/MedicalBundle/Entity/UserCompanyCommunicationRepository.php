<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserClinicCommunicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserCompanyCommunicationRepository extends EntityRepository
{
	/**
     * function getCommunicationDetail
     *
     * @param integer $snQuoteId   quote id
	 * @param integer $snIdCompany company id
	 * @param string  $ssType      user type
     *
     * @todo   Function get communication detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	 public function getCommunicationDetail($snQuoteId, $snIdCompany, $ssType='')
	 {
		$ssQuery = $this->createQueryBuilder('ucc')
						->select('ucc','c')
						->leftJoin('ucc.company','c')						
						->where('ucc.userquotedetails = :id')
						->setParameter("id", $snQuoteId)
						->andwhere('ucc.company = :companyid')
						->setParameter("companyid", $snIdCompany);
						if($ssType != '')
						{
							$ssQuery->andwhere('ucc.user_type = :type')
									->andwhere('ucc.company_offered_unique = :unique')
									 ->setParameter("type", $ssType)
									 ->setParameter("unique", "Yes")
									 ->orderBy('ucc.id','DESC');									 
						}
		return $ssQuery->getQuery()						
						->getArrayResult();		
	 }
	 
	 /**
     * function getAllCommunicationDetail
     *
     * @param integer $snQuoteId   quote id
	 * @param integer $snIdCompany company id
	 * @param string  $ssType      user type
     *
     * @todo   Function get communication detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	 public function getAllCommunicationDetail($snQuoteId, $snIdCompany, $ssType='')
	 {
		$ssQuery = $this->createQueryBuilder('ucc')
						->select('ucc','c')
						->leftJoin('ucc.company','c')						
						->where('ucc.userquotedetails = :id')
						->setParameter("id", $snQuoteId)
						->andwhere('ucc.company = :companyid')
						->setParameter("companyid", $snIdCompany);
						if($ssType != '')
						{
							$ssQuery->andwhere('ucc.user_type = :type')
									 ->setParameter("type", $ssType)
									 ->orderBy('ucc.id','DESC');									 
						}
		return $ssQuery->getQuery()						
						->getArrayResult();		
	 }
	 
	/**
     * function getCompanyCommunicationDetail
     *
     * @param integer $snQuoteId   quote id
	 * @param integer $snIdCompany company id
     *
     * @todo   Function get communication detail.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	 public function getCompanyCommunicationDetail($snQuoteId, $snCompanyId='')
	 {
		$ssQuery = $this->createQueryBuilder('ucc')
						->select('ucc','c.id,c.name','uqd.quote_status')
						->leftJoin('ucc.company','c')
						->leftJoin('ucc.userquotedetails','uqd')
						->Where('ucc.userquotedetails = :quoteid')
						->setParameter("quoteid", $snQuoteId);
						
						if($snCompanyId != '')
						{
							$ssQuery->andWhere('ucc.company = :id')
									->setParameter("id", $snCompanyId);	
						}
		return $asData = $ssQuery->getQuery()						
								 ->getArrayResult();		
	 }
	 
	 
	 /**
     * function getLoggedinCompanywiseQuoteDetail
     *
     * @param integer $snIdCompany company id
     *
     * @todo   Function get quote deail by loggedin company.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function getLoggedinCompanywiseQuoteDetail($snIdCompany='') 
    {	
		$ssSubQuery = $this->getEntityManager()
            ->createQuery("SELECT COUNT(ucq.id) FROM AdminMedicalBundle:UserCompanyCommunication ucq where ucq.checked_by_client = 'No' and ucq.user_type='user'  and ucq.userquotedetails = ucc.userquotedetails and ucq.company = ucc.company");
		
		$ssCompanyQuery = $this->getEntityManager()
            ->createQuery("SELECT IDENTITY(uccq.userquotedetails) FROM AdminMedicalBundle:UserCompanyQuotes uccq where uccq.quote_status = 'archive' and uccq.userquotedetails = ucc.userquotedetails and uccq.company = ".$snIdCompany);
		
		$asStatus = "'archive','blocked','unverified','Completed'";
		
		return $ssQuery = $this->createQueryBuilder('ucc')					
					->select('ucc.id,ucc.company_offered','uqd.firstname','uqd.lastname','uqd.id as user_quote_detail_id,('.$ssSubQuery->getDQL().') as cnt_unread_meesage')
					->leftJoin('ucc.userquotedetails','uqd')
					->where('ucc.company = :snId')
					->setParameter('snId', $snIdCompany)
					->andWhere('ucc.user_type = :ssUserType')
					->setParameter('ssUserType', 'user')
					->andWhere('uqd.quote_status NOT IN ('.$asStatus.')')
					->andWhere('uqd.id NOT IN ('.$ssCompanyQuery->getDQL().')')
					->groupBy('ucc.userquotedetails')
					->getQuery()
				    ->getArrayResult();		
	}
	
	/**
     * function getQuotewiseCompanyDetail
     *
     * @param integer $snQuoteId   quote id
     *
     * @todo   Function get except first five insurance companies who are assigned to most clinics.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function getQuotewiseCompanyDetail($snQuoteId='') 
    {	
		$ssSubQuery = $this->getEntityManager()
            ->createQuery("SELECT COUNT(ucq.id) FROM AdminMedicalBundle:UserCompanyCommunication ucq where ucq.checked_by_client = 'No' and ucq.user_type='company' and ucq.userquotedetails = '".$snQuoteId."' and ucq.company = ucc.company");
		
		$ssQuery = $this->createQueryBuilder('ucc')
					->select('ucc.id as commu_id, ucc.company_offered, ('.$ssSubQuery->getDQL().') as cnt_unread_meesage','c.id,c.name')
					->leftJoin('ucc.company','c')
					->where('ucc.userquotedetails = :snId')
					->setParameter('snId', $snQuoteId)
					->andWhere('ucc.user_type = :ssUserType')		
					->setParameter('ssUserType', 'user')
					->groupBy('ucc.company');
					
		return 	$ssQuery->getQuery()
				    	->getArrayResult();
	}
	
	/**
     * function updateDataByField
     *
     * @param integer $snIdQuote     quoteid
     * @param integer $snIdCompany   companyid
	 * @param string  $ssType        usertype
	 * @param string  $ssValue       value
	 * @param string  $ssFieldName   fieldname
     *
     * @todo   Function to update data.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function updateDataByField($snIdQuote, $snIdCompany, $ssType, $ssValue='Yes', $ssFieldName='checked_by_client') 
    {
        return $asData = $this->getEntityManager()
            ->createQuery("update AdminMedicalBundle:UserCompanyCommunication ucq set ucq.".$ssFieldName." = '".$ssValue."' where ucq.userquotedetails = ".$snIdQuote." and ucq.company = ".$snIdCompany." and ucq.checked_by_client = 'No' and ucq.user_type = '".$ssType."'")
            ->execute();
    }
	
	/**
     * function updateTwentyForNoReplyByField
     *
     * @param integer $snIdQuote     quoteid
     * @param integer $snIdCompany   companyid
	 * @param string  $ssType        usertype
	 * @param string  $ssValue       value
	 * @param string  $ssFieldName   fieldname
     *
     * @todo   Function to update twenty four reservation data.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return boolean
     */
	public function updateTwentyForNoReplyByField($snIdQuote, $snIdCompany, $ssType, $ssValue='Yes', $ssFieldName='checked_by_client') 
    {
        return $asData = $this->getEntityManager()
            ->createQuery("update AdminMedicalBundle:UserCompanyCommunication ucq set ucq.".$ssFieldName." = '".$ssValue."' where ucq.userquotedetails = ".$snIdQuote." and ucq.company = ".$snIdCompany." and ucq.user_type = '".$ssType."'")
            ->execute();
    }
	
	/**
     * function getDetailForSentMailByCron
     *
     * @param string $ssUserType   usertype
     * @param string $ssReplyType  replytype
     *
     * @todo   Function get detail for cron.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function getDetailForSentMailByCron($ssUserType='', $ssReplyType='') 
    {	
		$snDate = date("Y-m-d H:i:s", strtotime(' -1 day'));
		
        $ssQuery = $this->createQueryBuilder('ucc')
					->select('ucc','uqd','c')
					->leftJoin('ucc.userquotedetails','uqd')
					->leftJoin('ucc.company','c')
					->where('ucc.created_at < :snDate')
					->setParameter('snDate', $snDate)
					->andWhere('ucc.user_type = :ssUserType')
					->setParameter('ssUserType', $ssUserType)
					->andWhere('ucc.reply_type = :ssReplyType')
					->setParameter('ssReplyType', $ssReplyType)					
					->andWhere('ucc.twenty_four_no_reply IS NULL')
					->groupBy('ucc.company, ucc.userquotedetails');
					
		return $ssQuery->getQuery()
				->getArrayResult();
	}
	
	/**
     * function updateReplyType
     *
     * @param integer $snIdQuote     quoteid
     * @param integer $snIdCompany   companyid
	 * @param string  $ssType        usertype
	 * @param string  $ssValue       value
	 * @param string  $ssFieldName   fieldname
     *
     * @todo   Function to update reply type.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function updateReplyType($snIdQuote, $snIdCompany, $ssType, $ssValue='Yes', $ssFieldName='reply_type') 
    {
        return $asData = $this->getEntityManager()
            ->createQuery("update AdminMedicalBundle:UserCompanyCommunication ucq set ucq.".$ssFieldName." = '".$ssValue."' where ucq.userquotedetails = ".$snIdQuote." and ucq.company = ".$snIdCompany." and ucq.reply_type = 'No' and ucq.user_type = '".$ssType."'")
            ->execute();
    }
	
	/**
     * function updateCompanyOffer
     *
     * @param integer $snIdQuote     quoteid
     * @param integer $snIdCompany   companyid
	 * @param string  $ssType        usertype
	 * @param string  $ssValue       value
	 * @param string  $ssFieldName   fieldname
     *
     * @todo   Function to update company offer.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function updateCompanyOffer($snIdQuote, $snIdCompany, $ssType, $ssValue='Yes', $ssFieldName='company_offered') 
    {
        return $asData = $this->getEntityManager()
            ->createQuery("update AdminMedicalBundle:UserCompanyCommunication ucq set ucq.".$ssFieldName." = '".$ssValue."' where ucq.userquotedetails = ".$snIdQuote." and ucq.company = ".$snIdCompany." and ucq.user_type = '".$ssType."'")
            ->execute();
    }
	
	/**
     * function checkCompanyOffered
     *
     * @param integer $snQuoteId     quoteid
     * @param integer $snCompanyId   companyid
	 * @param string  $ssString      value	 
     *
     * @todo   Function to check company offeres or not.
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return single object
     */
	 public function checkCompanyOffered($snQuoteId, $snCompanyId, $ssString='Yes')
	 {
		return $ssQuery = $this->createQueryBuilder('ucc')
						->select('ucc')
						->leftJoin('ucc.company','c')
						->leftJoin('ucc.userquotedetails','uqd')
						->where('ucc.company = :id')
						->setParameter("id", $snCompanyId)
						->andwhere('ucc.userquotedetails = :quoteid')
						->setParameter("quoteid", $snQuoteId)
						->andwhere('ucc.company_offered_unique = :ssParam')
						->setParameter("ssParam", "Yes")
						->andWhere('ucc.user_type = :ssUserType')
						->setParameter('ssUserType', 'company')
						->getQuery()
						->getOneOrNullResult();
	 }
	 
	/**
     * function getActiveOrArchiveQuote
     *
     * @param string  $ssReplyType   reply type
     * @param string  $ssQuoteStatus quote status
     *
     * @todo   Function to get active or archive quote
     * @access public
     * @author Arpita Jadeja <arpita.j.php@gmail.com>
     * @return array
     */
	public function getActiveOrArchiveQuote($ssReplyType='', $ssQuoteStatus='') 
    {	
		$snDate = date("Y-m-d H:i:s", strtotime(' -15 day'));
		//$asStatus = "'archive','blocked','unverified','Completed'";
        $ssQuery = $this->createQueryBuilder('ucc')
					->select('ucc.id as user_communication_id','uqd.id as user_quote_id','c.id as company_id')
					->leftJoin('ucc.userquotedetails','uqd')
					->leftJoin('ucc.company','c')
					->where('ucc.created_at < :snDate')
					->setParameter('snDate', $snDate)
					->andWhere('ucc.reply_type = :ssReplyType')
					->setParameter('ssReplyType', $ssReplyType)
					->andWhere('ucc.user_type = :ssUserType OR ucc.user_type = :ssCompanyType')
					//->andWhere('uqd.quote_status NOT IN ('.$asStatus.')')
					->andWhere( 'uqd.quote_status != :ssQuoteStatus')
					->setParameter('ssQuoteStatus', $ssQuoteStatus)
					->setParameter('ssUserType', 'user')		
					->setParameter('ssCompanyType', 'company')
					->groupBy('ucc.userquotedetails');
					
		return $asData = $ssQuery->getQuery()
				          ->getArrayResult();        
	}
}