<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="Nom_clt", type="string", length=255, unique=false)
     */
    private $nomClt;

    /**
     * @var string
     *
     * @ORM\Column(name="Rais_soc_clt", type="string", length=5, unique=true)
     */
    private $raisSocClt;

    /**
     * @var string
     *
     * @ORM\Column(name="Siege_clt", type="string", length=30, unique=true)
     */
    private $siegeClt;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays_clt", type="string", length=16, unique=true)
     */
    private $paysClt;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel_clt", type="string", length=30, unique=true)
     */
    private $telClt;

    /**
     * @var string
     *
     * @ORM\Column(name="Email_clt", type="string", length=35, unique=true)
     */
    private $emailClt;


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
     * Set nomClt
     *
     * @param string $nomClt
     *
     * @return Client
     */
    public function setNomClt($nomClt)
    {
        $this->nomClt = $nomClt;

        return $this;
    }

    /**
     * Get nomClt
     *
     * @return string
     */
    public function getNomClt()
    {
        return $this->nomClt;
    }

    /**
     * Set raisSocClt
     *
     * @param string $raisSocClt
     *
     * @return Client
     */
    public function setRaisSocClt($raisSocClt)
    {
        $this->raisSocClt = $raisSocClt;

        return $this;
    }

    /**
     * Get raisSocClt
     *
     * @return string
     */
    public function getRaisSocClt()
    {
        return $this->raisSocClt;
    }

    /**
     * Set siegeClt
     *
     * @param string $siegeClt
     *
     * @return Client
     */
    public function setSiegeClt($siegeClt)
    {
        $this->siegeClt = $siegeClt;

        return $this;
    }

    /**
     * Get siegeClt
     *
     * @return string
     */
    public function getSiegeClt()
    {
        return $this->siegeClt;
    }

    /**
     * Set telClt
     *
     * @param string $telClt
     *
     * @return Client
     */
    public function setTelClt($telClt)
    {
        $this->telClt = $telClt;

        return $this;
    }

    /**
     * Get telClt
     *
     * @return string
     */
    public function getTelClt()
    {
        return $this->telClt;
    }

    /**
     * Set emailClt
     *
     * @param string $emailClt
     *
     * @return Client
     */
    public function setEmailClt($emailClt)
    {
        $this->emailClt = $emailClt;

        return $this;
    }

    /**
     * Get emailClt
     *
     * @return string
     */
    public function getEmailClt()
    {
        return $this->emailClt;
    }

    /**
     * Set paysClt
     *
     * @param string $paysClt
     * @return Client
     */
    public function setPaysClt($paysClt)
    {
        $this->paysClt = $paysClt;

        return $this;
    }

    /**
     * Get paysClt
     *
     * @return string 
     */
    public function getPaysClt()
    {
        return $this->paysClt;
    }
}
