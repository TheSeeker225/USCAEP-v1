<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\RegionRepository")
 */
class Region
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
     * @ORM\Column(name="Nom_reg", type="string", length=25, unique=true)
     * @Assert\Length(min=2, max=25, minMessage="Le nom de la région doit faire au moins {{ limit }} caractères." , maxMessage="Le nom de la région ne doit pas dépasser {{ limit }} caractères.")
     */
    private $nomReg;


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
     * Set nomReg
     *
     * @param string $nomReg
     * @return Region
     */
    public function setNomReg($nomReg)
    {
        $this->nomReg = $nomReg;

        return $this;
    }

    /**
     * Get nomReg
     *
     * @return string 
     */
    public function getNomReg()
    {
        return $this->nomReg;
    }
}
