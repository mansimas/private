<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Serializable;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * Admin
 *
 * @ORM\Table(name="Admin")
 * @ORM\Entity(repositoryClass="Admin\MedicalBundle\Entity\AdminRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Admin implements UserInterface, \Serializable 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=30)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="user_type", type="string", length=255)
     */
    private $userType;



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
     * @return Admin
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
     * Set login
     *
     * @param string $login
     * @return Admin
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Admin
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
     * Set password
     *
     * @param string $password
     * @return Admin
     */
    public function setPassword($password)
    {
        //$this->password = $password;
		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $this->password = $encoder->encodePassword($password, $this->getSalt());
    
        return $this;
    }

	    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {
        
    }

    public function getUsername() {
        return $this->login;
    }

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->login,
            $this->password,
			$this->userType,
			$this->name
        ));
    }

    public function unserialize($serialized) {
        list (
                $this->id,
                $this->login,
                $this->password,
				$this->userType,
				$this->name
                ) = unserialize($serialized);
    }

   
    /**
     * Constructor
     */
    public function __construct()
    {
        
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

    /**
     * Set userType
     *
     * @param string $userType
     * @return Admin
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    
        return $this;
    }

    /**
     * Get userType
     *
     * @return string 
     */
    public function getUserType()
    {
        return $this->userType;
    }
	public function getRoles() {
		return array('ROLE_ADMIN');
  }
}