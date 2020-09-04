<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Membre
 *
 * @ORM\Table(name="membre")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\MembreRepository")
 */
class Membre
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
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Cooperative")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $cooperative;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_mem", type="string", length=20, nullable=true)
     * @Assert\Length(min=3, minMessage="Le nom doit être d'au moins {{ limit }} carcatères")
     */
    private $nomMem;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom_mem", type="string", length=30, nullable=true)
     * @Assert\Length(min=3, minMessage="Le prénom doit être d'au moins {{ limit }} carcatères")
     */
    private $prenomMem;

    /**
     * @var \Date
     *
     * @ORM\Column(name="Date_nais_mem", type="date")
     * @Assert\Date()
     */
    private $dateNaisMem;

    /**
     * @var string
     *
     * @ORM\Column(name="Lieu_nais_mem", type="string", length=30)
     * @Assert\Length(min=4, minMessage="Le lieu de naissance doit être d'au moins {{ limit }} carcatères")
     */
    private $lieuNaisMem;

    /**
     * @var string
     *
     * @ORM\Column(name="Nation_mem", type="string", length=30)
     * @Assert\Country()
     */
    private $nationMem;

    /**
     * @var int
     *
     * @ORM\Column(name="Nb_enf_mem", type="smallint", nullable=true)
     */
    private $nbEnfMem;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe_mem", type="string", length=4, nullable=false)
     * @Assert\Choice(choices={"M","Mme","Mlle"}, message="Choisissez votre civilité")
     */
    private $sexeMem;

    /**
     * @var string
     *
     * @ORM\Column(name="Village_mem", type="string", length=30)
     * @Assert\Length(min=5, minMessage="Cette localité doit faire au moins {{ limit }} caractères")
     */
    private $villageMem;

    /**
     * @var string
     *
     * @ORM\Column(name="Cont_mem", type="string", length=17)
     * @Assert\Length(min=8, minMessage="Les contacts doivent faire au moins {{ limit }} caractères et séparés par un '/'")
     */
    private $contMem;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getIdentity()
    {
        $identity = ($this->sexeMem == "M") ? 'M.'.$this->prenomMem.' '.$this->nomMem : 'Mme '.$this->prenomMem.' '.$this->nomMem;
        return $identity;
    }

    /**
     * Get nomMem
     *
     * @return string
     */
    public function getNomMem()
    {
        return $this->nomMem;
    }

    /**
     * Set nomMem
     *
     * @param string $nomMem
     *
     * @return Membre
     */
    public function setNomMem($nomMem)
    {
        $this->nomMem = $nomMem;

        return $this;
    }

    /**
     * Get prenomMem
     *
     * @return string
     */
    public function getPrenomMem()
    {
        return $this->prenomMem;
    }

    /**
     * Set dateNaisMem
     *
     * @param \DateTime $dateNaisMem
     *
     * @return Membre
     */
    public function setDateNaisMem($dateNaisMem)
    {
        $this->dateNaisMem = $dateNaisMem;

        return $this;
    }

    /**
     * Get dateNaisMem
     *
     * @return \DateTime
     */
    public function getDateNaisMem()
    {
        return $this->dateNaisMem;
    }

    /**
     * Set lieuNaisMem
     *
     * @param string $lieuNaisMem
     *
     * @return Membre
     */
    public function setLieuNaisMem($lieuNaisMem)
    {
        $this->lieuNaisMem = $lieuNaisMem;

        return $this;
    }

    /**
     * Get lieuNaisMem
     *
     * @return string
     */
    public function getLieuNaisMem()
    {
        return $this->lieuNaisMem;
    }

    /**
     * Set nationMem
     *
     * @param string $nationMem
     *
     * @return Membre
     */
    public function setNationMem($nationMem)
    {
        $this->nationMem = $nationMem;

        return $this;
    }

    /**
     * Get nationMem
     *
     * @return string
     */
    public function getNationMem()
    {
        return $this->nationMem;
    }

    /**
     * Set nbEnfMem
     *
     * @param integer $nbEnfMem
     *
     * @return Membre
     */
    public function setNbEnfMem($nbEnfMem)
    {
        $this->nbEnfMem = $nbEnfMem;

        return $this;
    }

    /**
     * Get nbEnfMem
     *
     * @return int
     */
    public function getNbEnfMem()
    {
        return $this->nbEnfMem;
    }

    /**
     * Set villageMem
     *
     * @param string $villageMem
     *
     * @return Membre
     */
    public function setVillageMem($villageMem)
    {
        $this->villageMem = $villageMem;

        return $this;
    }

    /**
     * Get villageMem
     *
     * @return string
     */
    public function getVillageMem()
    {
        return $this->villageMem;
    }

    /**
     * Set contMem
     *
     * @param string $contMem
     *
     * @return Membre
     */
    public function setContMem($contMem)
    {
        $this->contMem = $contMem;

        return $this;
    }

    /**
     * Get contMem
     *
     * @return string
     */
    public function getContMem()
    {
        return $this->contMem;
    }

    /**
     * Set image
     *
     * @param \CoreBundle\Entity\Image $image
     *
     * @return Membre
     */
    public function setImage(\CoreBundle\Entity\Image $image = null)
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
     * Set prenomMem
     *
     * @param string $prenomMem
     *
     * @return Membre
     */
    public function setPrenomMem($prenomMem)
    {
        $this->prenomMem = $prenomMem;

        return $this;
    }

    /**
     * Set cooperative
     *
     * @param \CoreBundle\Entity\Cooperative $cooperative
     *
     * @return Membre
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
     * Set sexeMem
     *
     * @param string $sexeMem
     * @return Membre
     */
    public function setSexeMem($sexeMem)
    {
        $this->sexeMem = $sexeMem;

        return $this;
    }

    /**
     * Get sexeMem
     *
     * @return string 
     */
    public function getSexeMem()
    {
        return $this->sexeMem;
    }
}
