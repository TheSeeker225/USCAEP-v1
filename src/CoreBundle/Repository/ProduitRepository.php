<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends EntityRepository
{
    public function listePanier($tab = array()){

    	if (empty($tab)) {
            return null;
        } else {
            // Création de la réquête avec l'Objet Query et un DQL
            $quer5 = $this->_em->createQuery('SELECT p FROM CoreBundle:Produit p WHERE p.id IN ('.implode(',', $tab).')');

            return $quer5->getArrayResult();
        }
    
    }

    public function mettreJourStockProd($stock, $id)
    {
    	$quer7 = $this->_em->createQuery('UPDATE CoreBundle:Produit p SET p.stockPrd =:stock WHERE p.id =:id');
        $quer7->setParameter('stock', $stock); 
        $quer7->setParameter('id', $id);

        return $quer7->getResult();
    }
}