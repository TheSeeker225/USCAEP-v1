<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Figurer
 *
 * @ORM\Table(name="figurer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FigurerRepository")
 */
class Figurer
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
     * @var int
     *
     * @ORM\Column(name="Qte_cmd_prd", type="smallint")
     */
    private $qteCmdPrd;

    /**
     * @var int
     *
     * @ORM\Column(name="Pv_prd_cmd", type="integer", nullable=true)
     */
    private $pvPrdCmd;

    /*
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Produit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;


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
     * Get pvPrdCmd
     *
     * @return int
     */
    public function getpvPrdCmd()
    {
        return $this->pvPrdCmd;
    }

    /**
     * Set pvCmdPrd
     *
     * @param integer $pvCmdPrd
     *
     * @return Figurer
     */
    public function setpvPrdCmd($pvPrdCmd)
    {
        $this->pvPrdCmd = $pvPrdCmd;

        return $this;
    }

    /**
     * Set qteCmdPrd
     *
     * @param integer $qteCmdPrd
     *
     * @return Figurer
     */
    public function setQteCmdPrd($qteCmdPrd)
    {
        $this->qteCmdPrd = $qteCmdPrd;

        return $this;
    }

    /**
     * Get qteCmdPrd
     *
     * @return int
     */
    public function getQteCmdPrd()
    {
        return $this->qteCmdPrd;
    }

    /**
     * Set commande
     *
     * @param \AppBundle\Entity\Commande $commande
     *
     * @return Figurer
     */
    public function setCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \AppBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set produit
     *
     * @param \CoreBundle\Entity\Produit $produit
     *
     * @return Figurer
     */
    public function setProduit(\CoreBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \CoreBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
