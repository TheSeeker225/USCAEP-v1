<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cooperative
 *
 * @ORM\Table(name="cooperative")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\CooperativeRepository")
 */
class Cooperative
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
    * @ORM\ManytoOne(targetEntity="CoreBundle\Entity\Departement")
    * @ORM\JoinColumn(nullable=false)
    */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_coop", type="string", length=160, unique=true)
     * @Assert\Length(min=25, minMessage="Le sigle doit faire au moins {{ limit }} caractères")
     */
    private $nomCoop;

    /**
     * @var string
     *
     * @ORM\Column(name="Sigle_coop", type="string", length=10, unique=true)
     * @Assert\Length(min=3, minMessage="Le sigle doit faire au moins {{ limit }} caractères")
     */
    private $sigleCoop;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_adh_coop", type="datetime", nullable=true)
     */
    private $dateAdhCoop;

    /**
    * @var text
    *
    * @ORM\Column(name="Desc_coop", type="text", nullable=true)
    */
    private $descCoop;

    /**
     * @var string
     *
     * @ORM\Column(name="BP_coop", type="string", length=20, unique=true)
     */
    private $bPCoop;

    /**
     * @var string
     *
     * @ORM\Column(name="SP_coop", type="string", length=35)
     */
    private $sPCoop;

    /**
     * @var string
     *
     * @ORM\Column(name="Cont_coop", type="string", length=27, unique=true)
     */
    private $contCoop;


    public function __construct()
    {
        $this->dateAdhCoop = new \Datetime;
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
     * Set nomCoop
     *
     * @param string $nomCoop
     *
     * @return Cooperative
     */
    public function setNomCoop($nomCoop)
    {
        $this->nomCoop = $nomCoop;

        return $this;
    }

    /**
     * Get nomCoop
     *
     * @return string
     */
    public function getNomCoop()
    {
        return $this->nomCoop;
    }

    /**
     * Set dateAdhCoop
     *
     * @param \DateTime $dateAdhCoop
     *
     * @return Cooperative
     */
    public function setDateAdhCoop($dateAdhCoop)
    {
        $this->dateAdhCoop = $dateAdhCoop;

        return $this;
    }

    /**
     * Get dateAdhCoop
     *
     * @return \DateTime
     */
    public function getDateAdhCoop()
    {
        return $this->dateAdhCoop;
    }

    /**
     * Set descCoop
     *
     * @param string $descCoop
     *
     * @return Cooperative
     */
    public function setDescCoop($descCoop)
    {
        $this->descCoop = $descCoop;

        return $this;
    }

    /**
     * Get descCoop
     *
     * @return string
     */
    public function getDescCoop()
    {
        return $this->descCoop;
    }

    /**
     * Set resCoop
     *
     * @param string $resCoop
     *
     * @return Cooperative
     */
    public function setResCoop($resCoop)
    {
        $this->resCoop = $resCoop;

        return $this;
    }

    /**
     * Get resCoop
     *
     * @return string
     */
    public function getResCoop()
    {
        return $this->resCoop;
    }

    /**
     * Set bPCoop
     *
     * @param string $bPCoop
     *
     * @return Cooperative
     */
    public function setBPCoop($bPCoop)
    {
        $this->bPCoop = $bPCoop;

        return $this;
    }

    /**
     * Get bPCoop
     *
     * @return string
     */
    public function getBPCoop()
    {
        return $this->bPCoop;
    }

    /**
     * Set sPCoop
     *
     * @param string $sPCoop
     *
     * @return Cooperative
     */
    public function setSPCoop($sPCoop)
    {
        $this->sPCoop = $sPCoop;

        return $this;
    }

    /**
     * Get sPCoop
     *
     * @return string
     */
    public function getSPCoop()
    {
        return $this->sPCoop;
    }

    /**
     * Set contCoop
     *
     * @param string $contCoop
     *
     * @return Cooperative
     */
    public function setContCoop($contCoop)
    {
        $this->contCoop = $contCoop;

        return $this;
    }

    /**
     * Get contCoop
     *
     * @return string
     */
    public function getContCoop()
    {
        return $this->contCoop;
    }

    /**
     * Set departement
     *
     * @param \CoreBundle\Entity\Departement $departement
     *
     * @return Cooperative
     */
    public function setDepartement(\CoreBundle\Entity\Departement $departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \CoreBundle\Entity\Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set sigleCoop
     *
     * @param string $sigleCoop
     * @return Cooperative
     */
    public function setSigleCoop($sigleCoop)
    {
        $this->sigleCoop = $sigleCoop;

        return $this;
    }

    /**
     * Get sigleCoop
     *
     * @return string 
     */
    public function getSigleCoop()
    {
        return $this->sigleCoop;
    }
}
