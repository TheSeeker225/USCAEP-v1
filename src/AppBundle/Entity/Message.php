<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="Nom", type="string", length=40, unique=true)
     * @Assert\Length(min=8)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel", type="string", length=17, unique=true)
     * @Assert\Length(min=8)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=35, unique=true, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var date
     *
     * @ORM\Column(name="Date_ms", type="date")
     * @Assert\DateTime()
     */
    private $dateMs;

    /**
     * @var string
     *
     * @ORM\Column(name="Objet_ms", type="string", length=100, nullable=false)
     * @Assert\Length(min=16, minMessage="L'objet est obligatoire et doit être compris entre {{ limit }} et 100 caractères.")
     */
    private $objetMs;

    /**
     * @var string
     *
     * @ORM\Column(name="Contenu", type="string", length=225, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min=10, max=225, minMessage="Le message doit être compris entre {{ limit }} et 225 caractères.", maxMessage="Le message doit être compris entre 100 et {{ limit }} caractères.")
     */
    private $contenu;

    public function __construct()
    {
      $this->dateMs = new \Datetime();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Message
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Message
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
        return $this;
      }


    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set dateMs
     *
     * @param string $dateMs
     *
     * @return Message
     */
    public function setDate_ms($dateMs)
    {
        $this->tel = $dateMs;
        return $this;
      }


    /**
     * Get dateMs
     *
     * @return date
     */
    public function getDate_ms()
    {
        return $this->dateMs;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Message
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateMs
     *
     * @param \DateTime $dateMs
     *
     * @return Message
     */
    public function setDateMs($dateMs)
    {
        $this->dateMs = $dateMs;

        return $this;
    }

    /**
     * Get dateMs
     *
     * @return \DateTime
     */
    public function getDateMs()
    {
        return $this->dateMs;
    }

    /**
     * Set objetMs
     *
     * @param string $objetMs
     * @return Message
     */
    public function setObjetMs($objetMs)
    {
        $this->objetMs = $objetMs;

        return $this;
    }

    /**
     * Get objetMs
     *
     * @return string 
     */
    public function getObjetMs()
    {
        return $this->objetMs;
    }
}
