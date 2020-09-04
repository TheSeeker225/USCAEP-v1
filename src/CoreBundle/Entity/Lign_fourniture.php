<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lign_fourniture gère les lignes de fourniture des livraisons
 * 
 * @author Seeker225 AIJNWJ <wilfriedyoro68@gmail.com>
 *
 * @ORM\Table(name="lign_fourniture")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Lign_fournitureRepository")
 */
class Lign_fourniture
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
    * @var object
    *
    * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Livraison", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $livraison;

    /**
    * @var object
    *
    * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Produit")
    * @ORM\JoinColumn(nullable=false)
    */
    private $produit;

    /**
     * @var int
     *
     * @ORM\Column(name="Qte_fr_liv", type="smallint")
     */
    private $qteFrLiv;

    /**
     * @var int
     *
     * @ORM\Column(name="Pa_prd_liv", type="integer")
     */
    private $paPrdLiv;

    /**
     * @var string
     *
     * @ORM\Column(name="Qual_prd_liv", type="string", length=7)
     */
    private $qualPrdLiv;

    public function __construct()
    {

    }

    public function __destruct()
    {
        
    }

    /**
     * Get id récupère l'identifiant
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qteFrLiv définit la quantité fournie lors de la livraison
     *
     * @param integer $qteFrLiv
     *
     * @return Lign_fourniture
     */
    public function setQteFrLiv($qteFrLiv)
    {
        $this->qteFrLiv = $qteFrLiv;

        return $this;
    }

    /**
     * Get qteFrLiv récupère la quantité fournie lors de la livraison
     *
     * @return int
     */
    public function getQteFrLiv()
    {
        return $this->qteFrLiv;
    }

    /**
     * Set paPrdLiv définit le prix d'achat au kilogramme lors de la livraison
     *
     * @param integer $paPrdLiv
     *
     * @return Lign_fourniture
     */
    public function setPaPrdLiv($paPrdLiv)
    {
        $this->paPrdLiv = $paPrdLiv;

        return $this;
    }

    /**
     * Get paPrdLiv récupère le prix d'achat au kilogramme lors de la livraison
     *
     * @return int
     */
    public function getPaPrdLiv()
    {
        return $this->paPrdLiv;
    }

    /**
     * Set livraison définit la livraison à laquelle cette ligne de fourniture appartient
     *
     * @param \CoreBundle\Entity\Livraison $livraison
     *
     * @return Lign_fourniture
     */
    public function setLivraison(\CoreBundle\Entity\Livraison $livraison)
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * Get livraison récupère la livraison de cette ligne de fourniture
     *
     * @return \CoreBundle\Entity\Livraison
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * Set qualPrdLiv définit la qualité du produit lors de la livraison
     *
     * @param string $qualPrdLiv
     *
     * @return Lign_fourniture
     */
    public function setQualPrdLiv($qualPrdLiv)
    {
        $this->qualPrdLiv = $qualPrdLiv;

        return $this;
    }

    /**
     * Get qualPrdLiv récupère la qualité du produit lors de la livraison
     *
     * @return string
     */
    public function getQualPrdLiv()
    {
        return $this->qualPrdLiv;
    }

    /**
     * Set produit définit le produit approvisionné lors de la livraison
     *
     * @param \CoreBundle\Entity\Produit $produit
     * @return Lign_fourniture
     */
    public function setProduit(\CoreBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit récupère le produit approvisionné lors de la livraison
     *
     * @return \CoreBundle\Entity\Produit 
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
