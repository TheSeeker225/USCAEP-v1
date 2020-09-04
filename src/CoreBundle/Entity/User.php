<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserRepository")
 */
class User implements UserInterface 
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Union_coop")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $union_coop;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Cooperative")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $cooperative;

    // Attributs de connexion

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=16, nullable=true)
     * @Assert\Length(min=8)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=25, nullable=true)
     * @Assert\Length(min=10)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", nullable=true)
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     * @Assert\Email()
     */
    private $email;

    // Attributs de gestion

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_user", type="string", length=20, nullable=false)
     * @Assert\Length(min=3)
     */
    private $nomUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom_user", type="string", length=30, nullable=false)
     * @Assert\Length(min=3)
     */
    private $prenomUser;

    /**
     * @var \Date
     *
     * @ORM\Column(name="Date_nais_user", type="date", nullable=false)
     * @Assert\Date()
     */
    private $dateNaisUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Lieu_nais_user", type="string", length=30, nullable=false)
     * @Assert\Length(min=5)
     */
    private $lieuNaisUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Nation_user", type="string", length=35, nullable=false)
     * @Assert\Country()
     */
    private $nationUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe_user", type="string", length=4, nullable=false)
     * @Assert\Choice(choices={"M","Mme","Mlle"}, message="Choisissez votre civilité")
     */
    private $sexeUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Poste_user", type="string", length=50, nullable=false)
     * @Assert\Length(min=6, minMessage="Il doit faire au moins {{ limit }} caractères")
     */
    private $posteUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Resid_user", type="string", length=30, nullable=false)
     * @Assert\Length(min=5)
     */
    private $residUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Cont_user", type="string", length=17, nullable=false, unique=true)
     * @Assert\Length(min=8, minMessage="Les contacts doivent faire au moins {{ limit }} caractères et séparés par un '/'")
     */
    private $contUser;

    public function __construct()
    {
        $this->isActive = false;
        $this->username = '';
        $this->password = '';
        $this->roles = [];
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param boolean $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

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

    /**
     * Set password
     *
     * @param boolean $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set roles
     *
     * @param boolean $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set nomUser
     *
     * @param string $nomUser
     * @return User
     */
    public function setNomUser($nomUser)
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    /**
     * Get nomUser
     *
     * @return string 
     */
    public function getNomUser()
    {
        return $this->nomUser;
    }

    /**
     * Set prenomUser
     *
     * @param string $prenomUser
     * @return User
     */
    public function setPrenomUser($prenomUser)
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    /**
     * Get prenomUser
     *
     * @return string 
     */
    public function getPrenomUser()
    {
        return $this->prenomUser;
    }

    /**
     * Set dateNaisUser
     *
     * @param \DateTime $dateNaisUser
     * @return User
     */
    public function setDateNaisUser($dateNaisUser)
    {
        $this->dateNaisUser = $dateNaisUser;

        return $this;
    }

    /**
     * Get dateNaisUser
     *
     * @return \DateTime 
     */
    public function getDateNaisUser()
    {
        return $this->dateNaisUser;
    }

    /**
     * Set lieuNaisUser
     *
     * @param string $lieuNaisUser
     * @return User
     */
    public function setLieuNaisUser($lieuNaisUser)
    {
        $this->lieuNaisUser = $lieuNaisUser;

        return $this;
    }

    /**
     * Get lieuNaisUser
     *
     * @return string 
     */
    public function getLieuNaisUser()
    {
        return $this->lieuNaisUser;
    }

    /**
     * Set nationUser
     *
     * @param string $nationUser
     * @return User
     */
    public function setNationUser($nationUser)
    {
        $this->nationUser = $nationUser;

        return $this;
    }

    /**
     * Get nationUser
     *
     * @return string 
     */
    public function getNationUser()
    {
        return $this->nationUser;
    }

    /**
     * Set sexeUser
     *
     * @param string $sexeUser
     * @return User
     */
    public function setSexeUser($sexeUser)
    {
        $this->sexeUser = $sexeUser;

        return $this;
    }

    /**
     * Get sexeUser
     *
     * @return string 
     */
    public function getSexeUser()
    {
        return $this->sexeUser;
    }

    /**
     * Set posteUser
     *
     * @param string $posteUser
     * @return User
     */
    public function setPosteUser($posteUser)
    {
        $this->posteUser = $posteUser;

        return $this;
    }

    /**
     * Get posteUser
     *
     * @return string 
     */
    public function getPosteUser()
    {
        return $this->posteUser;
    }

    /**
     * Set residUser
     *
     * @param string $residUser
     * @return User
     */
    public function setResidUser($residUser)
    {
        $this->residUser = $residUser;

        return $this;
    }

    /**
     * Get residUser
     *
     * @return string 
     */
    public function getResidUser()
    {
        return $this->residUser;
    }

    /**
     * Set contUser
     *
     * @param string $contUser
     * @return User
     */
    public function setContUser($contUser)
    {
        $this->contUser = $contUser;

        return $this;
    }

    /**
     * Get contUser
     *
     * @return string 
     */
    public function getContUser()
    {
        return $this->contUser;
    }

    /**
     * Set image
     *
     * @param \CoreBundle\Entity\Image $image
     * @return User
     */
    public function setImage(\CoreBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \CoreBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set union_coop
     *
     * @param \CoreBundle\Entity\Union_coop $unionCoop
     * @return User
     */
    public function setUnionCoop(\CoreBundle\Entity\Union_coop $unionCoop)
    {
        $this->union_coop = $unionCoop;

        return $this;
    }

    /**
     * Get union_coop
     *
     * @return \CoreBundle\Entity\Union_coop 
     */
    public function getUnionCoop()
    {
        return $this->union_coop;
    }

    /**
     * Set cooperative
     *
     * @param \CoreBundle\Entity\Cooperative $cooperative
     * @return User
     */
    public function setCooperative(\CoreBundle\Entity\Cooperative $cooperative)
    {
        $this->cooperative = $cooperative;

        return $this;
    }

    /**
     * Get cooperative
     *
     * @return \CoreBundle\Entity\Cooperative 
     */
    public function getCooperative()
    {
        return $this->cooperative;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
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
}
