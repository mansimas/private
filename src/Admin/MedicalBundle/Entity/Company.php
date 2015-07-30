<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Serializable;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * Company
 */
class Company implements UserInterface, \Serializable
{
	use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $company_code;

    /**
     * @var string
     */
    private $vat_code;

    /**
     * @var string
     */
    private $licence_number;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var integer
     */
    private $zip;

    /**
     * @var boolean
     */
    private $disable_quotes;

    /**
     * @var integer
     */
    private $primary_phone;

    /**
     * @var integer
     */
    private $cell_phone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $company_note;

    /**
     * @var string
     */
    private $badges;

    /**
     * @var string
     */
    private $payment_option;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $insurances;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->insurances = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set company_code
     *
     * @param string $companyCode
     * @return Company
     */
    public function setCompanyCode($companyCode)
    {
        $this->company_code = $companyCode;

        return $this;
    }

    /**
     * Get company_code
     *
     * @return string
     */
    public function getCompanyCode()
    {
        return $this->company_code;
    }

    /**
     * Set vat_code
     *
     * @param string $vatCode
     * @return Company
     */
    public function setVatCode($vatCode)
    {
        $this->vat_code = $vatCode;

        return $this;
    }

    /**
     * Get vat_code
     *
     * @return string
     */
    public function getVatCode()
    {
        return $this->vat_code;
    }

    /**
     * Set licence_number
     *
     * @param string $licenceNumber
     * @return Company
     */
    public function setLicenceNumber($licenceNumber)
    {
        $this->licence_number = $licenceNumber;

        return $this;
    }

    /**
     * Get licence_number
     *
     * @return string
     */
    public function getLicenceNumber()
    {
        return $this->licence_number;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Company
     */
    public function setAddress($address)
    {
        //echo $address;exit;
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Company
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zip
     *
     * @param integer $zip
     * @return Company
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return integer
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set disable_quotes
     *
     * @param boolean $disableQuotes
     * @return Company
     */
    public function setDisableQuotes($disableQuotes)
    {
        $this->disable_quotes = $disableQuotes;

        return $this;
    }

    /**
     * Get disable_quotes
     *
     * @return boolean
     */
    public function getDisableQuotes()
    {
        return $this->disable_quotes;
    }

    /**
     * Set primary_phone
     *
     * @param integer $primaryPhone
     * @return Company
     */
    public function setPrimaryPhone($primaryPhone)
    {
        $this->primary_phone = $primaryPhone;

        return $this;
    }

    /**
     * Get primary_phone
     *
     * @return integer
     */
    public function getPrimaryPhone()
    {
        return $this->primary_phone;
    }

    /**
     * Set cell_phone
     *
     * @param integer $cellPhone
     * @return Company
     */
    public function setCellPhone($cellPhone)
    {
        $this->cell_phone = $cellPhone;

        return $this;
    }

    /**
     * Get cell_phone
     *
     * @return integer
     */
    public function getCellPhone()
    {
        return $this->cell_phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Company
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Company
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set company_note
     *
     * @param string $companyNote
     * @return Company
     */
    public function setCompanyNote($companyNote)
    {
        $this->company_note = $companyNote;

        return $this;
    }

    /**
     * Get company_note
     *
     * @return string
     */
    public function getCompanyNote()
    {
        return $this->company_note;
    }

    /**
     * Set badges
     *
     * @param string $badges
     * @return Company
     */
    public function setBadges($badges)
    {
        $this->badges = implode($badges,',');
        return $this;
    }

    /**
     * Get badges
     *
     * @return string
     */
    public function getBadges()
    {
        return explode(',',$this->badges);
    }

    /**
     * Set payment_option
     *
     * @param string $paymentOption
     * @return Company
     */
    public function setPaymentOption($paymentOption)
    {
        $this->payment_option = implode($paymentOption,',');
        return $this;
    }

    /**
     * Get payment_option
     *
     * @return string
     */
    public function getPaymentOption()
    {
        return explode(',',$this->payment_option);
    }

    public function setCreatedAtValue()
	{
	  if(!$this->getCreatedAt())
	  {
		$this->created_at = new \DateTime();
	  }
	}
	// ...
	public function setUpdatedAtValue()
	{
	  $this->updated_at = new \DateTime();
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
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $specialoffers;


    /**
     * Add specialoffers
     *
     * @param \Admin\MedicalBundle\Entity\SpecialOffers $specialoffers
     * @return Company
     */
    public function addSpecialoffer(\Admin\MedicalBundle\Entity\SpecialOffers $specialoffers)
    {
        $this->specialoffers[] = $specialoffers;

        return $this;
    }

    /**
     * Remove specialoffers
     *
     * @param \Admin\MedicalBundle\Entity\SpecialOffers $specialoffers
     */
    public function removeSpecialoffer(\Admin\MedicalBundle\Entity\SpecialOffers $specialoffers)
    {
        $this->specialoffers->removeElement($specialoffers);
    }

    /**
     * Get specialoffers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecialoffers()
    {
        return $this->specialoffers;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ratings;


    /**
     * Add ratings
     *
     * @param \Admin\MedicalBundle\Entity\Ratings $ratings
     * @return Company
     */
    public function addRating(\Admin\MedicalBundle\Entity\Ratings $ratings)
    {
        $this->ratings[] = $ratings;

        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \Admin\MedicalBundle\Entity\Ratings $ratings
     */
    public function removeRating(\Admin\MedicalBundle\Entity\Ratings $ratings)
    {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $service;


    /**
     * Add service
     *
     * @param \Admin\MedicalBundle\Entity\Service $service
     * @return Company
     */
    public function addService(\Admin\MedicalBundle\Entity\Service $service)
    {
        $this->service[] = $service;

        return $this;
    }

    /**
     * Remove service
     *
     * @param \Admin\MedicalBundle\Entity\Service $service
     */
    public function removeService(\Admin\MedicalBundle\Entity\Service $service)
    {
        $this->service->removeElement($service);
    }

    /**
     * Get service
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $experience;


    /**
     * Add experience
     *
     * @param \Admin\MedicalBundle\Entity\Experience $experience
     * @return Company
     */
    public function addExperience(\Admin\MedicalBundle\Entity\Experience $experience)
    {
        $this->experience[] = $experience;

        return $this;
    }

    /**
     * Remove experience
     *
     * @param \Admin\MedicalBundle\Entity\Experience $experience
     */
    public function removeExperience(\Admin\MedicalBundle\Entity\Experience $experience)
    {
        $this->experience->removeElement($experience);
    }

    /**
     * Get experience
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExperience()
    {
        return $this->experience;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $doctor;


    /**
     * Add doctor
     *
     * @param \Admin\MedicalBundle\Entity\Doctor $doctor
     * @return Company
     */
    public function addDoctor(\Admin\MedicalBundle\Entity\Doctor $doctor)
    {
        $this->doctor[] = $doctor;

        return $this;
    }

    /**
     * Remove doctor
     *
     * @param \Admin\MedicalBundle\Entity\Doctor $doctor
     */
    public function removeDoctor(\Admin\MedicalBundle\Entity\Doctor $doctor)
    {
        $this->doctor->removeElement($doctor);
    }

    /**
     * Get doctor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDoctor()
    {
        return $this->doctor;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usercompanyrequest;


    /**
     * Add usercompanyrequest
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyRequest $usercompanyrequest
     * @return Company
     */
    public function addUsercompanyrequest(\Admin\MedicalBundle\Entity\UserCompanyRequest $usercompanyrequest)
    {
        $this->usercompanyrequest[] = $usercompanyrequest;

        return $this;
    }

    /**
     * Remove usercompanyrequest
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyRequest $usercompanyrequest
     */
    public function removeUsercompanyrequest(\Admin\MedicalBundle\Entity\UserCompanyRequest $usercompanyrequest)
    {
        $this->usercompanyrequest->removeElement($usercompanyrequest);
    }

    /**
     * Get usercompanyrequest
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsercompanyrequest()
    {
        return $this->usercompanyrequest;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $companyimages;


    /**
     * Add companyimages
     *
     * @param \Admin\MedicalBundle\Entity\CompanyImages $companyimages
     * @return Company
     */
    public function addCompanyimage(\Admin\MedicalBundle\Entity\CompanyImages $companyimages)
    {
        $this->companyimages[] = $companyimages;

        return $this;
    }

    /**
     * Remove companyimages
     *
     * @param \Admin\MedicalBundle\Entity\CompanyImages $companyimages
     */
    public function removeCompanyimage(\Admin\MedicalBundle\Entity\CompanyImages $companyimages)
    {
        $this->companyimages->removeElement($companyimages);
    }

    /**
     * Get companyimages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanyimages()
    {
        return $this->companyimages;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $news;


    /**
     * Add news
     *
     * @param \Admin\MedicalBundle\Entity\News $news
     * @return Company
     */
    public function addNew(\Admin\MedicalBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \Admin\MedicalBundle\Entity\News $news
     */
    public function removeNew(\Admin\MedicalBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usercompanyquotes;


    /**
     * Add usercompanyquotes
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes
     * @return Company
     */
    public function addUsercompanyquote(\Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes)
    {
        $this->usercompanyquotes[] = $usercompanyquotes;

        return $this;
    }

    /**
     * Remove usercompanyquotes
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes
     */
    public function removeUsercompanyquote(\Admin\MedicalBundle\Entity\UserCompanyQuotes $usercompanyquotes)
    {
        $this->usercompanyquotes->removeElement($usercompanyquotes);
    }

    /**
     * Get usercompanyquotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsercompanyquotes()
    {
        return $this->usercompanyquotes;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Company
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Company
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userquotedetails;


    /**
     * Add userquotedetails
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails
     * @return Company
     */
    public function addUserquotedetail(\Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails)
    {
        $this->userquotedetails[] = $userquotedetails;

        return $this;
    }

    /**
     * Remove userquotedetails
     *
     * @param \Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails
     */
    public function removeUserquotedetail(\Admin\MedicalBundle\Entity\UserQuoteDetail $userquotedetails)
    {
        $this->userquotedetails->removeElement($userquotedetails);
    }

    /**
     * Get userquotedetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserquotedetails()
    {
        return $this->userquotedetails;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $prices;


    /**
     * Add prices
     *
     * @param \Admin\MedicalBundle\Entity\Prices $prices
     * @return Company
     */
    public function addPrice(\Admin\MedicalBundle\Entity\Prices $prices)
    {
        $this->prices[] = $prices;

        return $this;
    }

    /**
     * Remove prices
     *
     * @param \Admin\MedicalBundle\Entity\Prices $prices
     */
    public function removePrice(\Admin\MedicalBundle\Entity\Prices $prices)
    {
        $this->prices->removeElement($prices);
    }

    /**
     * Get prices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrices()
    {
        return $this->prices;
    }
    /**
     * @var string
     */
    private $password;


    /**
     * Set password
     *
     * @param string $password
     * @return Company
     */
    public function setPassword($password)
    {
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $this->password = $encoder->encodePassword($password, $this->getSalt());

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

	public function getSalt() {
        return null;
    }

    public function eraseCredentials() {

    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
        return $this;
    }

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->email,
            $this->name,
            $this->username,
//            $this->password
        ));
    }

    public function unserialize($serialized) {
        list (
            $this->id,
            $this->email,
            $this->name,
            $this->username,
//            $this->password
            ) = unserialize($serialized);
    }

	public function getRoles() {
    return array('ROLE_CLINIC');
  }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usercompanycommunication;


    /**
     * Add usercompanycommunication
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication
     * @return Company
     */
    public function addUsercompanycommunication(\Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication)
    {
        $this->usercompanycommunication[] = $usercompanycommunication;

        return $this;
    }

    /**
     * Remove usercompanycommunication
     *
     * @param \Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication
     */
    public function removeUsercompanycommunication(\Admin\MedicalBundle\Entity\UserCompanyCommunication $usercompanycommunication)
    {
        $this->usercompanycommunication->removeElement($usercompanycommunication);
    }

    /**
     * Get usercompanycommunication
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsercompanycommunication()
    {
        return $this->usercompanycommunication;
    }


    /**
     * @var \Admin\MedicalBundle\Entity\Country
     */
    private $countries;


    /**
     * Set countries
     *
     * @param \Admin\MedicalBundle\Entity\Country $countries
     * @return Company
     */
    public function setCountries(\Admin\MedicalBundle\Entity\Country $countries = null)
    {
        $this->countries = $countries;

        return $this;
    }

    /**
     * Get countries
     *
     * @return \Admin\MedicalBundle\Entity\Country
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * Add insurances
     *
     * @param \Admin\MedicalBundle\Entity\Insurance $insurances
     * @return Company
     */
    public function addInsurance(\Admin\MedicalBundle\Entity\Insurance $insurances)
    {
        $this->insurances[] = $insurances;

        return $this;
    }

    /**
     * Remove insurances
     *
     * @param \Admin\MedicalBundle\Entity\Insurance $insurances
     */
    public function removeInsurance(\Admin\MedicalBundle\Entity\Insurance $insurances)
    {
        $this->insurances->removeElement($insurances);
    }

    /**
     * Get insurances
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInsurances()
    {
        return $this->insurances;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $languagess;


    /**
     * Add languagess
     *
     * @param \Admin\MedicalBundle\Entity\Languages $languagess
     * @return Company
     */
    public function addLanguages(\Admin\MedicalBundle\Entity\Languages $languagess)
    {
        $this->languagess[] = $languagess;

        return $this;
    }

    /**
     * Remove languagess
     *
     * @param \Admin\MedicalBundle\Entity\Languages $languagess
     */
    public function removeLanguages(\Admin\MedicalBundle\Entity\Languages $languagess)
    {
        $this->languagess->removeElement($languagess);
    }

    /**
     * Get languagess
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLanguagess()
    {
        return $this->languagess;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $paymentoptions;


    /**
     * Add paymentoptions
     *
     * @param \Admin\MedicalBundle\Entity\PaymentOption $paymentoptions
     * @return Company
     */
    public function addPaymentoption(\Admin\MedicalBundle\Entity\PaymentOption $paymentoptions)
    {
        $this->paymentoptions[] = $paymentoptions;

        return $this;
    }

    /**
     * Remove paymentoptions
     *
     * @param \Admin\MedicalBundle\Entity\PaymentOption $paymentoptions
     */
    public function removePaymentoption(\Admin\MedicalBundle\Entity\PaymentOption $paymentoptions)
    {
        $this->paymentoptions->removeElement($paymentoptions);
    }

    /**
     * Get paymentoptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentoptions()
    {
        return $this->paymentoptions;
    }
    /**
     * @var integer
     */
    private $fixed_fee;

    /**
     * @var integer
     */
    private $fixed_fee_percentage;


    /**
     * Set fixed_fee
     *
     * @param integer $fixedFee
     * @return Company
     */
    public function setFixedFee($fixedFee)
    {
        $this->fixed_fee = $fixedFee;

        return $this;
    }

    /**
     * Get fixed_fee
     *
     * @return integer
     */
    public function getFixedFee()
    {
        return $this->fixed_fee;
    }

    /**
     * Set fixed_fee_percentage
     *
     * @param integer $fixedFeePercentage
     * @return Company
     */
    public function setFixedFeePercentage($fixedFeePercentage)
    {
        $this->fixed_fee_percentage = $fixedFeePercentage;

        return $this;
    }

    /**
     * Get fixed_fee_percentage
     *
     * @return integer
     */
    public function getFixedFeePercentage()
    {
        return $this->fixed_fee_percentage;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $category;


    /**
     * Add category
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $category
     * @return Company
     */
    public function addCategory(\Admin\MedicalBundle\Entity\CompanyCategory $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $category
     */
    public function removeCategory(\Admin\MedicalBundle\Entity\CompanyCategory $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $root;


    /**
     * Add root
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $root
     * @return Company
     */
    public function addRoot(\Admin\MedicalBundle\Entity\CompanyCategory $root)
    {
        $this->root[] = $root;

        return $this;
    }

    /**
     * Remove root
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $root
     */
    public function removeRoot(\Admin\MedicalBundle\Entity\CompanyCategory $root)
    {
        $this->root->removeElement($root);
    }

    /**
     * Get root
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoot()
    {
        return $this->root;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $companies;


    /**
     * Add companies
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $companies
     * @return Company
     */
    public function addCompanie(\Admin\MedicalBundle\Entity\CompanyCategory $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \Admin\MedicalBundle\Entity\CompanyCategory $companies
     */
    public function removeCompanie(\Admin\MedicalBundle\Entity\CompanyCategory $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        return $this->companies;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $companyvideos;


    /**
     * Add companyvideos
     *
     * @param \Admin\MedicalBundle\Entity\CompanyVideo $companyvideos
     * @return Company
     */
    public function addCompanyvideo(\Admin\MedicalBundle\Entity\CompanyVideo $companyvideos)
    {
        $this->companyvideos[] = $companyvideos;

        return $this;
    }

    /**
     * Remove companyvideos
     *
     * @param \Admin\MedicalBundle\Entity\CompanyVideo $companyvideos
     */
    public function removeCompanyvideo(\Admin\MedicalBundle\Entity\CompanyVideo $companyvideos)
    {
        $this->companyvideos->removeElement($companyvideos);
    }

    /**
     * Get companyvideos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanyvideos()
    {
        return $this->companyvideos;
    }
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $keyword;
    protected $badge_text_M;
    protected $badge_text_C;
    protected $badge_text_I;
    protected $badge_text_H;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $translations;


    /**
     * Set title
     *
     * @param string $title
     * @return Company
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return Company
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set badge text
     *
     * @param string $badge_text_M
     * @return Company
     */
    public function setBadge_text_M($badge_text_M)
    {
        $this->badge_text_M = $badge_text_M;

        return $this;
    }

    /**
     * Get badge text
     *
     * @return string
     */
    public function getBadge_text_M()
    {
        return $this->badge_text_M;
    }

    /**
     * Set badge text
     *
     * @param string $badge_text_C
     * @return Company
     */
    public function setBadge_text_C($badge_text_C)
    {
        $this->badge_text_C = $badge_text_C;

        return $this;
    }

    /**
     * Get badge text
     *
     * @return string
     */
    public function getBadge_text_C()
    {
        return $this->badge_text_C;
    }

    /**
     * Set badge text
     *
     * @param string $badge_text_I
     * @return Company
     */
    public function setBadge_text_I($badge_text_I)
    {
        $this->badge_text_I = $badge_text_I;

        return $this;
    }

    /**
     * Get badge text
     *
     * @return string
     */
    public function getBadge_text_I()
    {
        return $this->badge_text_I;
    }

    /**
     * Set badge text
     *
     * @param string
     * @return Company
     */
    public function setBadge_text_H($badge_text_H)
    {
        $this->badge_text_H = $badge_text_H;

        return $this;
    }

    /**
     * Get badge text
     *
     * @return string
     */
    public function getBadge_text_H()
    {
        return $this->badge_text_H;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add translations
     *
     * @param \Admin\MedicalBundle\Entity\Companytranslation $translations
     * @return Company
     */
    public function addTranslation(\Admin\MedicalBundle\Entity\Companytranslation $translations)
    {
        $this->translations[] = $translations;
        $translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Admin\MedicalBundle\Entity\Companytranslation $translations
     */
    public function removeTranslation(\Admin\MedicalBundle\Entity\Companytranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }
    /**
     * @var string
     */
    private $premium_company;


    /**
     * Set premium_company
     *
     * @param string $premiumCompany
     * @return Company
     */
    public function setPremiumCompany($premiumCompany)
    {
        $this->premium_company = $premiumCompany;

        return $this;
    }

    /**
     * Get premium_company
     *
     * @return string
     */
    public function getPremiumCompany()
    {
        return $this->premium_company;
    }
    /**
     * @var boolean
     */
    private $final_price_info;


    /**
     * Set final_price_info
     *
     * @param boolean $finalPriceInfo
     * @return Company
     */
    public function setFinalPriceInfo($finalPriceInfo)
    {
        $this->final_price_info = $finalPriceInfo;

        return $this;
    }

    /**
     * Get final_price_info
     *
     * @return boolean
     */
    public function getFinalPriceInfo()
    {
        return $this->final_price_info;
    }
    /**
     * @var boolean
     */
    private $small_company;


    /**
     * Set small_company
     *
     * @param boolean $smallCompany
     * @return Company
     */
    public function setSmallCompany($smallCompany)
    {
        $this->small_company = $smallCompany;

        return $this;
    }

    /**
     * Get small_company
     *
     * @return boolean
     */
    public function getSmallCompany()
    {
        return $this->small_company;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $doctors;


    /**
     * Get doctors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDoctors()
    {
        return $this->doctors;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
}
