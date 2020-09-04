<?php

namespace CoreBundle\Repository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends \Doctrine\ORM\EntityRepository
{
    public function listePartenaires()
    {
        
        $partenaires = [6, 7, 8];
        // Création de la réquête avec l'Objet Query et un DQL
        $quer1 = $this->_em->createQuery('SELECT i FROM CoreBundle:Image i WHERE i.id IN ('.implode(',', $partenaires).')');

        return $quer1->getResult();
    }

    public function voirImages($nomProd=null, $nomCoop=null)
    {
        if ($nomCoop == null) { // Si le nom appartient à un produit
            $quer2 = $this->_em->createQuery('SELECT i FROM CoreBundle:Image i JOIN i.produit p WHERE p.nomPrd =:nom');

            $quer2->setParameter('nom', $nomProd);
        } else { // Si le nom appartient à une coopérative
            $quer2 = $this->_em->createQuery('SELECT i FROM CoreBundle:Image i JOIN i.cooperative c WHERE c.nomCoop =:nom');

            $quer2->setParameter('nom', $nomCoop);
        }

        return $quer2->getResult();
    }

    public function choisirImage($id= 1)
    {
        $quer3 = $this->_em->createQuery('SELECT i, p FROM CoreBundle:Image i JOIN i.produit p WHERE i.id =:id');
        $quer3->setParameter('id', $id);
        return $quer3->getResult();
    }

    public function listeActivites()
    {
        
        $activites = [9, 10, 11];
        // Création de la réquête avec l'Objet Query et un DQL
        $quer4 = $this->_em->createQuery('SELECT i FROM CoreBundle:Image i WHERE i.id IN ('.implode(',', $activites).')');

        return $quer4->getResult();
    }

    public function listeSliders()
    {
        
        $sliders = [12, 13, 14, 58];
        // Création de la réquête avec l'Objet Query et un DQL
        $quer5 = $this->_em->createQuery('SELECT i FROM CoreBundle:Image i WHERE i.id IN ('.implode(',', $sliders).')');

        return $quer5->getResult();
    }

    public function listeProduits($group)
    {
        $quer6 = $this->_em->createQuery('SELECT i, p FROM CoreBundle:Image i JOIN i.produit p WHERE p.groupPrd =:group AND i.altImg = p.nomPrd AND i.onlImg = true');

        $quer6->setParameter('group', $group);

        return $quer6->getResult();
    }

    public function listeParDomaine($domaine)
    {
        $quer7 = $this->_em->createQuery('SELECT i, p FROM CoreBundle:Image i JOIN i.produit p WHERE p.domPrd =:domaine AND i.altImg = p.nomPrd AND i.onlImg = true');

        $quer7->setParameter('domaine', $domaine);

        return $quer7->getResult();
    }

    public function listeCooperatives()
    {
        $quer8 = $this->_em->createQuery('SELECT i, c FROM CoreBundle:Image i JOIN i.cooperative c WHERE i.altImg = c.nomCoop AND i.onlImg = true');

        return $quer8->getResult();
    }
    
}