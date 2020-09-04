<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(name="Nom_prd", type="string", length=20, unique=true)
     * @Assert\Length(min=3, minMessage="Il doit faire au moins {{ limit }} caractères")
     */
    private $nomPrd;

    /**
     * @var string
     *
     * @ORM\Column(name="Pres_prd", type="text", nullable=true)
     * @Assert\Length(min=255, minMessage="Il doit faire au moins {{ limit }} caractères")
     */
    private $presPrd;

    /**
     * @var string
     *
     * @ORM\Column(name="Dom_prd", type="string", length=16, nullable=false)
     * @Assert\Length(min=7, minMessage="Il doit faire au moins {{ limit }} caractères")
     */
    private $domPrd;

    /**
     * @var string
     *
     * @ORM\Column(name="Group_prd", type="string", length=18, nullable=true)
     * @Assert\Length(min=6, minMessage="Il doit faire au moins {{ limit }} caractères")
     */
    private $groupPrd;

    /**
     * @var int
     *
     * @ORM\Column(name="Stock_prd", type="integer")
     */
    private $stockPrd;


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
     * Set nomPrd
     *
     * @param string $nomPrd
     *
     * @return Produit
     */
    public function setNomPrd($nomPrd)
    {
        $this->nomPrd = $nomPrd;

        return $this;
    }

    /**
     * Get nomPrd
     *
     * @return string
     */
    public function getNomPrd()
    {
        return $this->nomPrd;
    }

    /**
     * Set presPrd
     *
     * @param string $presPrd
     *
     * @return Produit
     */
    public function setPresPrd($presPrd)
    {
        $this->presPrd = $presPrd;

        return $this;
    }

    /**
     * Get presPrd
     *
     * @return string
     */
    public function getPresPrd()
    {
        return $this->presPrd;
    }

    /**
     * Set domPrd
     *
     * @param string $domPrd
     *
     * @return Produit
     */
    public function setDomPrd($domPrd)
    {
        $this->domPrd = $domPrd;

        return $this;
    }

    /**
     * Get domPrd
     *
     * @return string
     */
    public function getDomPrd()
    {
        return $this->domPrd;
    }

    /**
     * Set groupPrd
     *
     * @param string $groupPrd
     *
     * @return Produit
     */
    public function setGroupPrd($groupPrd)
    {
        $this->groupPrd = $groupPrd;

        return $this;
    }

    /**
     * Get groupPrd
     *
     * @return string
     */
    public function getGroupPrd()
    {
        return $this->groupPrd;
    }

    /**
     * Set stockPrd
     *
     * @param string $stockPrd
     *
     * @return Produit
     */
    public function setStockPrd($trans,$stockPrd)
    {
        switch ($trans) {
            case 'ach':
                $this->stockPrd -= $stockPrd;
                break;
            
            default:
                $this->stockPrd += $stockPrd;
                break;
        }
        

        return $this;
    }

    /**
     * Get stockPrd
     *
     * @return string
     */
    public function getStockPrd()
    {
        return $this->stockPrd;
    }
}
