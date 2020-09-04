<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table(name="departement")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\DepartementRepository")
 */
class Departement
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
    * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Region")
    * @ORM\JoinColumn(nullable=false)
    */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_dep", type="string", length=30, unique=true)
     */
    private $nomDep;


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
     * Set nomDep
     *
     * @param string $nomDep
     *
     * @return Departement
     */
    public function setNomDep($nomDep)
    {
        $this->nomDep = $nomDep;

        return $this;
    }

    /**
     * Get nomDep
     *
     * @return string
     */
    public function getNomDep()
    {
        return $this->nomDep;
    }

    /**
     * Set region
     *
     * @param \CoreBundle\Entity\Region $region
     *
     * @return Departement
     */
    public function setRegion(\CoreBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \CoreBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }
}
