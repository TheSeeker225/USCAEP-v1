<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 */
class Commande
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
    *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Client", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="Rais_cmd", type="string", length=100)
     */
    private $raisCmd;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat_cmd", type="string", length=3)
     */
    private $etatCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_cmd", type="datetime")
     */
    private $dateCmd;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_liv_cmd", type="string", length=50)
     */
    private $lieuLivCmd;


    public function __construct()
    {
        $this->dateCmd = new \Datetime();
        $this->etatCmd = 'A'; // A correspond à en attente, N à annulée et E à éffectuée
        $this->raisCmd = 'Le client est en négociation avec l\'USCAEP.';
    }


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
     * Set etatCmd
     *
     * @param string $etatCmd
     *
     * @return Commande
     */
    public function setEtatCmd($etatCmd)
    {
        $this->etatCmd = $etatCmd;

        return $this;
    }

    /**
     * Get etatCmd
     *
     * @return string
     */
    public function getEtatCmd()
    {
        return $this->etatCmd;
    }

    /**
     * Set dateCmd
     *
     * @param \DateTime $dateCmd
     *
     * @return Commande
     */
    public function setDateCmd($dateCmd)
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    /**
     * Get dateCmd
     *
     * @return \DateTime
     */
    public function getDateCmd()
    {
        return $this->dateCmd;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Commande
     */
    public function setClient(\AppBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set raisCmd
     *
     * @param string $raisCmd
     *
     * @return Commande
     */
    public function setRaisCmd($raisCmd)
    {
        $this->raisCmd = $raisCmd;

        return $this;
    }

    /**
     * Get raisCmd
     *
     * @return string
     */
    public function getRaisCmd()
    {
        return $this->raisCmd;
    }

    /**
     * Set lieuLivCmd
     *
     * @param string $lieuLivCmd
     * @return Commande
     */
    public function setLieuLivCmd($lieuLivCmd)
    {
        $this->lieuLivCmd = $lieuLivCmd;

        return $this;
    }

    /**
     * Get lieuLivCmd
     *
     * @return string 
     */
    public function getLieuLivCmd()
    {
        return $this->lieuLivCmd;
    }
}
