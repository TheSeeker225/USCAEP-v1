<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Union_coop
 *
 * @ORM\Table(name="union_coop")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Union_coopRepository")
 */
class Union_coop
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
     * @var string
     *
     * @ORM\Column(name="Nom_un", type="string", length=255, unique=true)
     * @Assert\Length(min=16, minMessage="Le nom doit faire au moins {{ limit }} caractères")
     */
    private $nomUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Sigle_un", type="string", length=10, unique=true)
     * @Assert\Length(min=3, minMessage="Le sigle doit faire au moins {{ limit }} caractères")
     */
    private $sigleUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Siege_un", type="string", length=100, unique=true)
     * @Assert\Length(min=17, minMessage="Il doit faire au moins {{ limit }} caractères.")
     */
    private $siegeUn;

    /**
     * @var string
     *
     * @ORM\Column(name="E_mail_un", type="string", length=35, unique=true)
     * @Assert\Email(message="L'e-mail n'est pas valide.")
     */
    private $eMailUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Heur_un", type="string", length=31, nullable=true, unique=true)
     * @Assert\Length(min=30, minMessage="Il doit faire au moins {{ limit }} caractères.")
     */
    private $heurUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel_un", type="string", length=35, unique=true)
     * @Assert\Length(min=15, minMessage="Un contact vaut au moins {{ limit }} caractères.")
     */
    private $telUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Pres_un", type="text", nullable=false)
     */
    private $presUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Hist_un", type="text", nullable=false)
     */
    private $histUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Objet_un", type="text", nullable=false)
     */
    private $objetUn;

    /**
     * @var string
     *
     * @ORM\Column(name="But_un", type="text", nullable=false)
     */
    private $butUn;

    /**
     * @var string
     *
     * @ORM\Column(name="Objectif_un", type="text", nullable=false)
     */
    private $objectifUn;

    /**
     * @var string
     *
     * @ORM\Column(name="lnk_fb_un", type="string", length=100, nullable=true, unique=true)
     * @Assert\Length(min=32, minMessage="Ce lien doit faire au moins {{ limit }} caractères.")
     * @Assert\Url(message="Le lien {{ value }} n'est pas valide", protocols = {"http", "https", "ftp"})
     */
    private $lnkFbUn;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomUn
     *
     * @param string $nomUn
     *
     * @return Union_coop
     */
    public function setNomUn($nomUn)
    {
        $this->nomUn = $nomUn;

        return $this;
    }

    /**
     * Get nomUn
     *
     * @return string
     */
    public function getNomUn()
    {
        return $this->nomUn;
    }

    /**
     * Set siegeUn
     *
     * @param string $siegeUn
     *
     * @return Union_coop
     */
    public function setSiegeUn($siegeUn)
    {
        $this->siegeUn = $siegeUn;

        return $this;
    }

    /**
     * Get siegeUn
     *
     * @return string
     */
    public function getSiegeUn()
    {
        return $this->siegeUn;
    }

    /**
     * Set eMailUn
     *
     * @param string $eMailUn
     *
     * @return Union_coop
     */
    public function setEMailUn($eMailUn)
    {
        $this->eMailUn = $eMailUn;

        return $this;
    }

    /**
     * Get eMailUn
     *
     * @return string
     */
    public function getEMailUn()
    {
        return $this->eMailUn;
    }

    /**
     * Set heurUn
     *
     * @param string $heurUn
     *
     * @return Union_coop
     */
    public function setHeurUn($heurUn)
    {
        $this->heurUn = $heurUn;

        return $this;
    }

    /**
     * Get heurUn
     *
     * @return string
     */
    public function getHeurUn()
    {
        return $this->heurUn;
    }

    /**
     * Set telUn
     *
     * @param string $telUn
     *
     * @return Union_coop
     */
    public function setTelUn($telUn)
    {
        $this->telUn = $telUn;

        return $this;
    }

    /**
     * Get telUn
     *
     * @return string
     */
    public function getTelUn()
    {
        return $this->telUn;
    }

    /**
     * Set presUn
     *
     * @param string $presUn
     *
     * @return Union_coop
     */
    public function setPresUn($presUn)
    {
        $this->presUn = $presUn;

        return $this;
    }

    /**
     * Get presUn
     *
     * @return string
     */
    public function getPresUn()
    {
        return $this->presUn;
    }

    /**
     * Set histUn
     *
     * @param string $histUn
     *
     * @return Union_coop
     */
    public function setHistUn($histUn)
    {
        $this->histUn = $histUn;

        return $this;
    }

    /**
     * Get histUn
     *
     * @return string
     */
    public function getHistUn()
    {
        return $this->histUn;
    }

    /**
     * Set objetUn
     *
     * @param string $objetUn
     *
     * @return Union_coop
     */
    public function setObjetUn($objetUn)
    {
        $this->objetUn = $objetUn;

        return $this;
    }

    /**
     * Get objetUn
     *
     * @return string
     */
    public function getObjetUn()
    {
        return $this->objetUn;
    }

    /**
     * Set butUn
     *
     * @param string $butUn
     *
     * @return Union_coop
     */
    public function setButUn($butUn)
    {
        $this->butUn = $butUn;

        return $this;
    }

    /**
     * Get butUn
     *
     * @return string
     */
    public function getButUn()
    {
        return $this->butUn;
    }

    /**
     * Set objectifUn
     *
     * @param string $objectifUn
     *
     * @return Union_coop
     */
    public function setObjectifUn($objectifUn)
    {
        $this->objectifUn = $objectifUn;

        return $this;
    }

    /**
     * Get objectifUn
     *
     * @return string
     */
    public function getObjectifUn()
    {
        return $this->objectifUn;
    }

    /**
     * Set lnkFbUn
     *
     * @param string $lnkFbUn
     *
     * @return Union_coop
     */
    public function setLnkFbUn($lnkFbUn)
    {
        $this->lnkFbUn = $lnkFbUn;

        return $this;
    }

    /**
     * Get lnkFbUn
     *
     * @return string
     */
    public function getLnkFbUn()
    {
        return $this->lnkFbUn;
    }

    /**
     * Set codeImg
     *
     * @param integer $codeImg
     *
     * @return Union_coop
     */
    public function setCodeImg($codeImg)
    {
        $this->codeImg = $codeImg;

        return $this;
    }

    /**
     * Get codeImg
     *
     * @return integer
     */
    public function getCodeImg()
    {
        return $this->codeImg;
    }


    /**
     * Set sigleUn
     *
     * @param string $sigleUn
     * @return Union_coop
     */
    public function setSigleUn($sigleUn)
    {
        $this->sigleUn = $sigleUn;

        return $this;
    }

    /**
     * Get sigleUn
     *
     * @return string 
     */
    public function getSigleUn()
    {
        return $this->sigleUn;
    }
}
