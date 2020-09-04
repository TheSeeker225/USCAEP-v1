<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison gère les livraisons enregistrées
 * 
 * @author Seeker225 AIJNWJ <wilfriedyoro68@gmail.com>
 *
 * @ORM\Table(name="livraison")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\LivraisonRepository")
 */
class Livraison
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
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Membre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre;

    /**
     * @var string
     *
     * @ORM\Column(name="Rais_liv", type="string", length=100, nullable=true)
     */
    private $raisLiv;

    /**
     * @var int
     *
     * @ORM\Column(name="Mont_pay_liv", type="integer")
     */
    private $montPayLiv;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat_liv", type="string", length=2)
     */
    private $etatLiv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_liv", type="datetime")
     */
    private $dateLiv;

    public function __construct()
    {
        $this->dateLiv = new \Datetime();
        $this->etatLiv = 'AN'; // A -> paiement en cours, N -> Non terminé, E -> Paiement effectué et T -> Terminé
        $this->raisLiv = 'La totalité du paiement se fera dans les 2 prochains jours.';
        $this->montPayLiv = 0;
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
     * Set libelLiv
     *
     * @param string $libelLiv
     *
     * @return Livraison
     */
    public function setLibelLiv($libelLiv)
    {
        $this->libelLiv = $libelLiv;

        return $this;
    }

    /**
     * Get libelLiv
     *
     * @return string
     */
    public function getLibelLiv()
    {
        return $this->libelLiv;
    }

    /**
     * Set montPayLiv
     *
     * @param string $montPayLiv
     *
     * @return Livraison
     */
    public function setMontPayLiv($montPayLiv)
    {
        $this->montPayLiv = $montPayLiv;

        return $this;
    }

    /**
     * Get montPayLiv
     *
     * @return string
     */
    public function getMontPayLiv()
    {
        return $this->montPayLiv;
    }

    /**
     * Set etatLiv
     *
     * @param string $etatLiv
     *
     * @return Livraison
     */
    public function setEtatLiv($etatLiv)
    {
        $this->etatLiv = $etatLiv;

        return $this;
    }

    /**
     * Get etatLiv
     *
     * @return string
     */
    public function getEtatLiv()
    {
        return $this->etatLiv;
    }

    /**
     * Set dateLiv
     *
     * @param \DateTime $dateLiv
     *
     * @return Livraison
     */
    public function setDateLiv($dateLiv)
    {
        $this->dateLiv = $dateLiv;

        return $this;
    }

    /**
     * Get dateLiv
     *
     * @return \DateTime
     */
    public function getDateLiv()
    {
        return $this->dateLiv;
    }

    /**
     * Set matMem
     *
     * @param integer $matMem
     *
     * @return Livraison
     */
    public function setMatMem($matMem)
    {
        $this->matMem = $matMem;

        return $this;
    }

    /**
     * Get matMem
     *
     * @return int
     */
    public function getMatMem()
    {
        return $this->matMem;
    }

    /**
     * Set membre
     *
     * @param \CoreBundle\Entity\Membre $membre
     *
     * @return Livraison
     */
    public function setMembre(\CoreBundle\Entity\Membre $membre)
    {
        $this->membre = $membre;

        return $this;
    }

    /**
     * Get membre
     *
     * @return \CoreBundle\Entity\Membre
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * Set raisLiv
     *
     * @param string $raisLiv
     *
     * @return Livraison
     */
    public function setRaisLiv($raisLiv)
    {
        $this->raisLiv = $raisLiv;

        return $this;
    }

    /**
     * Get raisLiv
     *
     * @return string
     */
    public function getRaisLiv()
    {
        return $this->raisLiv;
    }
}
