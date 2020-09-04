<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ImageRepository")
 */
class Image
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
     *@ORM\ManyToOne(targetEntity="CoreBundle\Entity\Union_coop", cascade={"persist", "remove"})
     */
    private $union_coop;

    /**
     *@ORM\ManyToOne(targetEntity="CoreBundle\Entity\Produit", cascade={"persist", "remove"})
     */
    private $produit;

    /**
     *@ORM\ManyToOne(targetEntity="CoreBundle\Entity\Cooperative", cascade={"persist", "remove"})
     */
    private $cooperative;

    /**
     * @var text
     *
     * @ORM\Column(name="Desc_img", type="text", nullable=true)
     */
    private $descImg;

    /**
     * @var text
     *
     * @ORM\Column(name="Dir_img", type="string", length=12, nullable=false)
     */
    private $dirImg;

    /**
     * @var string
     *
     * @ORM\Column(name="Ext_img", type="string", length=4, unique=false)
     */
    private $extImg ;

    /**
     * @var string
     *
     * @ORM\Column(name="Alt_img", type="string", length=30, unique=true)
     * @Assert\Length(min=3, minMessage="Il doit faire au moins {{ limit }} caractères")
     */
    private $altImg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_img", type="datetime")
     */
    private $dateImg;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Onl_img", type="boolean", unique=false)
     */
    private $onlImg;

    private $file;

    private $tempFilename;

    public function getFile()
    {
        return $this->file;
    }

    public function preUpload()
    {
        if (null === $this->file) {
            return;
        } else {
            # Récupération de l'extension de l'image
            $this->extImg = $this->file->guessExtension();

            $name = $this->id.'.'.$this->extImg;
            return $name;
        }
        
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    public function getWebPath()
    {
        # Récupération du dossier hôte
        $entity = $this->dirImg;
        $parent = null;
        # le cas où l'image appartient soit à une union, soit à une coopérative, soit à un produit
            if ($this->getUnionCoop() != null) 
                $parent = $this->getUnionCoop()->getSigleUn();
        # le cas où l'image appartient à une coopérative
            if ($this->getCooperative() != null) 
                $parent = $this->getCooperative()->getSigleCoop();
        # le cas où l'image appartient à un produit
            if ($this->getProduit() != null) 
                $parent = htmlentities($this->getProduit()->getNomPrd());
        
        # Génération du chemin de l'image
        if ($parent == null)
            return '/USCAEP/web/'.$this->getUploadDir($entity).'/'.$this->getId().'.'.$this->getExtImg();
        else
            return '/USCAEP/web/'.$this->getUploadDir($entity).'/'.$parent.'/'.$this->getId().'.'.$this->getExtImg();
        
        
        
    }

    public function upload($form, $parent = null)
    {
        # Récupération du dossier hôte et génération du nom
        $entity = $this->dirImg;
        # Sans fichier, on ne fait rien
        if (null === $this->file) {
            return;
        } else {
            # Dans le cas où il faut changer d'image, On supprime l'ancien
            if (null !== $this->tempFilename) {
                # Chargement de l'ancien fichier
                # Si cette image n'appartient ni à un produit, ni à une coopérative ou à une union
                if ($parent === null)
                    $oldFile = $this->getUploadRootDir($entity).'\\'.$this->getId().'.'.$this->tempFilename;
                else
                    # Déplacement du nouveau fichier vers le dossier cible
                    $oldFile = $this->getUploadRootDir($entity).'\\'.$parent.'\\'.$this->getId().'.'.$this->tempFilename;
                
                if (file_exists($oldFile))
                    # Suppression du fichier
                    unlink($oldFile);
            } else {
                # On récupère le fichier
                $file = $form['file']->getData();
                # Si cette image appartient soit à un produit, soit à une coopérative soit à une union
                if ($parent == null)
                    # Déplacement du nouveau fichier vers le dossier cible
                    $file->move($this->getUploadRootDir($entity).'\\', $this->id.'.'.$this->extImg);
                else
                    # Déplacement du nouveau fichier vers le dossier cible
                    $file->move($this->getUploadRootDir($entity).'\\'.$parent.'\\', $this->id.'.'.$this->extImg);
            }
            
        }
        
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        # Récupération du dossier hôte
        $entity = $this->dirImg;
        # Sauvegarde temporaire du nom du fichier
        if ($this->getCooperative() == null && $this->getUnionCoop() == null && $this->getProduit() == null)
        {
            $this->tempFilename = $this->getUploadRootDir($entity).'\\'.$this->id.'.'.$this->extImg;
        }else {
            # le cas où l'image appartient soit à une union, soit à une coopérative, soit à un produit
            if ($this->getCooperative() != null) $parent = $this->getCooperative()->sigleCoop;

            if ($this->getUnionCoop() != null) $parent = $this->getUnionCoop()->sigleUn;

            if ($this->getProduit() != null) $parent = htmlentities($this->getProduit()->getNomPrd());

            $this->tempFilename = $this->getUploadRootDir($entity).'\\'.$parent.'\\'.$this->id.'.'.$this->extImg;
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename)) {
            # Suppression du fichier
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        # Récupération du dossier hôte
        $entity = $this->dirImg;
        switch ($entity) {
            case 'membres':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'backend/v2/dist/img/membres';
                break;
            case 'employes':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'backend/v2/dist/img/employes';
                break;
            case 'users':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'backend/v2/dist/img/users';
                break;
            case 'carousel':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'frontend/img/carousel';
                break;
            case 'cooperatives':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'frontend/img/cooperatives';
                break;
            case 'others':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'frontend/img/others';
                break;
            case 'produits':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'frontend/img/produits';
                break;
            case 'unions':
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'frontend/img\unions';
                break;
            
            default:
                # Chemin relatif du dossier cible (par rapport à /web)
                return 'frontend/img/others';
                break;
        }
        
    }

    public function getUploadRootDir()
    {
        # Récupération du dossier hôte
        $entity = $this->dirImg;
        # Chemin relatif pour le code PHP
        return __DIR__.'\..\..\..\web\\'.$this->getUploadDir($entity) ;
    }

    public function __construct()
    {
        $this->onlImg = false;
        $this->dateImg = new \Datetime;
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
     * Set descImg
     *
     * @param string $descImg
     *
     * @return Image
     */
    public function setDescImg($descImg)
    {
        $this->descImg = $descImg;

        return $this;
    }

    /**
     * Get descImg
     *
     * @return string
     */
    public function getDescImg()
    {
        return $this->descImg;
    }

    /**
     * Set extImg
     *
     * @param string $extImg
     *
     * @return Image
     */
    public function setExtImg($extImg)
    {
        $this->extImg = $extImg;

        return $this;
    }

    /**
     * Get extImg
     *
     * @return string
     */
    public function getExtImg()
    {
        return $this->extImg;
    }

    /**
     * Set altImg
     *
     * @param string $altImg
     *
     * @return Image
     */
    public function setAltImg($altImg)
    {
        $this->altImg = $altImg;

        return $this;
    }

    /**
     * Get altImg
     *
     * @return string
     */
    public function getAltImg()
    {
        return $this->altImg;
    }

    /**
     * Set produit
     *
     * @param \CoreBundle\Entity\Produit $produit
     *
     * @return Image
     */
    public function setProduit(\CoreBundle\Entity\Produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \CoreBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set onlImg
     *
     * @param boolean $onlImg
     *
     * @return Image
     */
    public function setOnlImg($onlImg)
    {
        $this->onlImg = $onlImg;

        return $this;
    }

    /**
     * Get onlImg
     *
     * @return boolean
     */
    public function getOnlImg()
    {
        return $this->onlImg;
    }

    /**
     * Set dateAddImg
     *
     * @param \DateTime $dateAddImg
     *
     * @return Image
     */
    public function setDateAddImg($dateAddImg)
    {
        $this->dateAddImg = $dateAddImg;

        return $this;
    }

    /**
     * Get dateAddImg
     *
     * @return \DateTime
     */
    public function getDateAddImg()
    {
        return $this->dateAddImg;
    }

    /**
     * Set cooperative
     *
     * @param \CoreBundle\Entity\Cooperative $cooperative
     *
     * @return Image
     */
    public function setCooperative(\CoreBundle\Entity\Cooperative $cooperative = null)
    {
        $this->cooperative = $cooperative;

        return $this;
    }

    /**
     * Get cooperative
     *
     * @return \CoreBundle\Entity\Cooperative
     */
    public function getCooperative()
    {
        return $this->cooperative;
    }

    /**
     * Set dateImg
     *
     * @param \DateTime $dateImg
     * @return Image
     */
    public function setDateImg($dateImg)
    {
        $this->dateImg = $dateImg;

        return $this;
    }

    /**
     * Get dateImg
     *
     * @return \DateTime 
     */
    public function getDateImg()
    {
        return $this->dateImg;
    }

    /**
     * Set dirImg
     *
     * @param string $dirImg
     * @return Image
     */
    public function setDirImg($dirImg)
    {
        $this->dirImg = $dirImg;

        return $this;
    }

    /**
     * Get dirImg
     *
     * @return string 
     */
    public function getDirImg()
    {
        return $this->dirImg;
    }

    /**
     * Set union_coop
     *
     * @param \CoreBundle\Entity\Union_coop $unionCoop
     * @return Image
     */
    public function setUnionCoop(\CoreBundle\Entity\Union_coop $unionCoop = null)
    {
        $this->union_coop = $unionCoop;

        return $this;
    }

    /**
     * Get union_coop
     *
     * @return \CoreBundle\Entity\Union_coop 
     */
    public function getUnionCoop()
    {
        return $this->union_coop;
    }
}
