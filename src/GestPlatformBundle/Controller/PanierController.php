<?php

namespace GestPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use CoreBundle\Entity\Membre;
use CoreBundle\Entity\Livraison;
use CoreBundle\Entity\Lign_fourniture;

use CoreBundle\Form\Lign_fournitureType;
use CoreBundle\Form\LivraisonEditType;
use CoreBundle\Form\LivraisonType;

/**
 * PanierController gère toutes les routes relatives aux approvisionnements 
 * 
 * @author Seeker225 AIJNWJ <wilfriedyoro68@gmail.com>
 */

class PanierController extends Controller
{
    /**
     * Em demande un EntityManager
     * 
     * @return EntityManager
     */
    private function _em()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * GetCooperative renvoie la coopérative en cours
     * 
     * @return Cooperative
     */
    private function getCooperative($id)
    {
      return $this->_em()->getRepository('CoreBundle:Cooperative')->findOneById($id);
    }

    /**
     * ContactUnion fournit les coordonnées de l'USCAEP
     * 
     * @return QueryResult
     */
    private function contactUnion()
    {
        return $this->_em()->getRepository('CoreBundle:Union_coop')->voirContactUnion();
    }

    /*
     * @Security("has_role('ROLE_USER')") 
     */
    /**
     * IndexAction s'occupe de l'affichage de l'accueil
     *
     * @param int  $id
     * 
     * @return render
     */
    public function indexAction($id)
    {
        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        return $this->render('GestPlatformBundle:Default:index.html.twig', 
            ['alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    /*
     * @Security("has_role('ROLE_USER')") 
     */
    /**
     * addLigneAction s'occupe de l'ajout d'une ligne de livraison
     *
     * @param Request $request
     * @param int  $id
     * @param int $prd
     * 
     * @return render
     */
    public function addLigneAction(Request $request, $id)
    {
        if ($id != 'nouveau') {
            $livraison = $this->_em()->getRepository('CoreBundle:Livraison')->findOneById($id);
            if (null === $livraison) {
                throw new NotFoundHttpException("Cette livraison n'existe pas. Si besoin est, <b>veuillez contacter le poste d'administration !</b>");
            }
            $app = true;
        } else $app = false;
        // On initialise la ligne
        $ligne = new Lign_fourniture();

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        
        // On charge la coopérative en cours
        $maCoop = $this->getCooperative(1);

        // On met en place le formulaire d'ajout du produit
        $formLign = ($app != true) ? $this->createForm(Lign_fournitureType::class, $ligne) : $this->createForm(Lign_fournitureType::class, $ligne)->remove('livraison');
            
        
        if ($request->isMethod('POST') && $formLign->handleRequest($request)->isValid()) {
            $manager = $this->_em();
            ;
            /* Si la livraison est nouvelle alors
                celle-ci est enregistrée et affectée à la ligne
                sinon elle est simplement affectée à la ligne */
            ($app != true) ? $manager->persist($ligne->getLivraison()) : $ligne->setLivraison($livraison);
            $manager->persist($ligne); $manager->flush();
            // On retourne au tableau de bord
            return $this->redirectToRoute('gest_platform_trans_view', ['id' => $ligne->getLivraison()->getId()]);


        }

        return $this->render('GestPlatformBundle:approv:new_lign.html.twig', ['formLign' => $formLign->createView(), 'maCoop' => $maCoop, 'alertApp' => $alertApp, 'app' => $app, 'alertMail' => $alertMail]);
    }

    /*
     * @Security("has_role('ROLE_USER')") 
     */
    /**
     * RecapAction s'occupe du récapitulatif de l'approvisionnement
     *
     * @param Request $request
     * @param int  $id
     * 
     * @return render
     */
    public function recapAction(Request $request, $id)
    {
        /* Si la livraison est nouvelle, on l'instancie 
          sinon, on charge l'objet correspondant */
        $livraison = ($id == 'nouveau') ? new Livraison() : $this->_em()->getRepository('CoreBundle:Livraison')->findOneById($id);

        if (null === $livraison) {
            throw new NotFoundHttpException("Cette livraison n'est pas disponible. Si besoin est, <b>veuillez contacter le poste d'administration !</b>");
        }

        $lignes = $this->_em()->getRepository('CoreBundle:Livraison')->listeLignes($livraison);

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        
        $formLiv = $this->createForm(LivraisonEditType::class, $livraison)
                    ->remove('membre')->remove('dateLiv');

        if ($request->isMethod('POST') && $formLiv->handleRequest($request)->isValid()) {

            // Si la livraison est finalisée, on l'enregistre en base de données
            $manager = $this->_em();
            foreach ($lignes as $ligne) {
                $produit = $this->_em()
                        ->getRepository('CoreBundle:Produit')
                        ->findOneByNomPrd($ligne->getProduit()->getNomPrd());
                $produit->setStockPrd('liv', $ligne->getQteFrLiv());
                $this->_em()->getRepository('CoreBundle:Produit')
                        ->mettreJourStockProd($produit->getStockPrd(), $produit->getId());
            }
            $livraison->setEtatLiv('AT');
            $manager->flush();

            $request->getSession()->getFlashBag()->add('new-liv', 'La livraison a bien été enregistrée');

            // On retourne au tableau de bord
            return $this->redirectToRoute('gest_platform_homepage');
        }
        
        // On charge la coopérative en cours
        $maCoop = $this->getCooperative(1);

        // On charge les informations sur l'USCAEP
        $uscaep = $this->contactUnion();

        return $this->render('GestPlatformBundle:approv:recap.html.twig', ['formLiv' => $formLiv->createView(), 'uscaep' => $uscaep, 'maCoop' => $maCoop, 'livraison' => $livraison, 'lignes' => $lignes, 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    /* 
     * @Security("has_role('ROLE_USER')") 
     */
    /**
     * printAction qui gère l'impression du reçu d'un approvisionnement
     * 
     * @param Request $request
     * @param int  $id
     * 
     * @throws NotFoundHttpFoundation 
     * 
     * @return render
     */
    public function printAction(Request $request, $id)
    {
        // Vérifions que la livraison est en base de données
        $app = $this->_em()->getRepository('CoreBundle:Livraison')->findOneById($id);
        if (null === $app) {
            throw new NotFoundHttpException("Cette livraison n'existe pas. <b>Si besoin est, veuillez contacter le poste d'administration !</b>");
        }

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();

        // On liste les lignes de fourniture correspondantes à la livraison 
        $lignes = $this->_em()->getRepository('CoreBundle:Livraison')->listeLignes($app);

        return $this->render('GestPlatformBundle:approv:print.html.twig', 
                            ['app' => $app, 'lignes' => $lignes, 'alertMail' => $alertMail]);
    }

    /* 
     * @Security("has_role('ROLE_USER')") 
     */
    /**
     * ViewAppAction qui gère l'affichage du reçu d'un approvisionnement
     * 
     * @param Request $request
     * @param int  $id
     * 
     * @throws NotFoundHttpFoundation 
     * 
     * @return render
     */
    public function viewAppAction(Request $request, $id)
    {
        // Vérifions que la livraison est en base de données
        $app = $this->_em()->getRepository('CoreBundle:Livraison')->findOneById($id);
        if (null === $app) {
            throw new NotFoundHttpException("Cette livraison n'existe pas. <b>Si besoin est, veuillez contacter le poste d'administration !</b>");
        }
        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();

        // On liste les lignes de fourniture correspondantes à la livraison 
        $lignes = $this->_em()->getRepository('CoreBundle:Lign_fourniture')->findByLivraison($app);

        return $this->render('GestPlatformBundle:approv:view_app.html.twig', 
                            ['app' => $app, 'lignes' => $lignes, 'alertMail' => $alertMail]);
    }

    /**
     * ModifierAction permet de modifier une ligne de fourniture
     * 
     * @param Request $request
     * @param int   $id
     * 
     * @return render
     */
    public function modifierAction(Request $request, $id, $liv)
	{
        // Vérifions que la livraison est en base de données
        $ligne = $this->_em()->getRepository('CoreBundle:Lign_fourniture')->findOneById($id);
        if (null === $ligne) {
            throw new NotFoundHttpException("Cette ligne n'existe pas ou n'est plus disponible. <b>Si besoin est, veuillez contacter le poste d'administration !</b>");
        }

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // On met en place le formulaire d'ajout du produit
        $formLign = ($produit->nomPrd != 'cacao' && $produit->nomPrd != 'café') 
                    ? $this->createForm(Lign_fournitureType::class, $ligne)
                        ->remove('qualPrdLiv') 
                    : $this->createForm(Lign_fournitureType::class, $ligne) ;
        
        // Vérifions que le formulaire est bien rempli et valide
        if ($request->isMethod('POST') && $formLign->handleRequest($request)->isValid()) 
        {
            
            $manager = $this->_em();
            $manager->flush();
            $ligne->__destruct();

            $request->getSession()->getFlashBag()->add('mod-ligne', 'La ligne a été modifiée.');
            
            // On se dirige vers le récapitulatif de la livraison en cours
            return $this->redirectToRoute('gest_platform_trans_recap', ['id' => $liv]);
        }  
        
        return $this->render('gest_platform_lign_mod', ['id' => $id, 'formLign' => createView(), 'alertMail' => $alertMail]);
	}

    /**
     * SupprimerAction permet de supprimer la ligne de fourniture
     * 
     * @param Request $request
     * @param int   $id
     * 
     * @return render
     */
    public function supprimerAction(Request $request, $id, $liv)
	{
        // Vérifions que la livraison est en base de données
        $ligne = $this->_em()->getRepository('CoreBundle:Lign_fourniture')->findOneById($id);
        if (null === $ligne) {
            throw new NotFoundHttpException("Cette ligne n'existe pas ou n'est plus disponible. <b>Si besoin est, veuillez contacter le poste d'administration !</b>");
        }
        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();

        $manager = $this->_em();
        $manager->remove($ligne);
        $manager->flush();

        $request->getSession()->getFlashBag()->add('del-ligne', 'La ligne a été supprimée.');
            
            // On se dirige vers le récapitulatif de la livraison en cours
        return $this->redirectToRoute('gest_platform_trans_recap', ['id' => $liv, 'alertMail' => $alertMail]);
	}
	  
}