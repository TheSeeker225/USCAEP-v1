<?php 

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use AppBundle\Entity\Client;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Figurer;


use AppBundle\Form\CommandeType;
use AppBundle\Form\FigurerType;

class PanierController extends Controller
{
	private function em()
    {
        return $this->getDoctrine()->getManager();
    }

	public function contactUnion()
    {
        return $this->em()->getRepository('CoreBundle:Union_coop')->recupererContactUnion();
    }

	  /**
   	 * @Route("/espace-publicitaire", name="boutique")
     */
    public function marketAction(Request $request)
    {
      	// Récupération de la session
      	$session = $request->getSession();

      	// Récupération des contacts de l'USCAEP
      	$contUn = $this->contactUnion();

      	// Récupération des produits disponibles
      	$cultures = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->listeProduits("Cultures de rente");
        $cereales = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->listeProduits("Céréales");
        $fruits = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->listeProduits("Fruits");
        $derives = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->listeProduits("Produits dérivés");
        $legumes = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->listeProduits("Légumes");


      	// On vérifie que l'internaute a déjà un panier
      	if(!$session->has('panier'))
        	$session->set('panier', []);

      	$panier = $session->get('panier');

      	

      	return $this->render('boutique/market.html.twig',
                        ['cultures' => $cultures, 'cereales' => $cereales, 'fruits' => $fruits, 'derives' => $derives, 'legumes' => $legumes, 'panier' => $panier, 'contact' => $contUn]);
  	}

  /**
   * @Route("/espace-publicitaire/produits/{prod}", name="details_produit")
   */
  public function produitAction(Request $request, $prod)
  {
      // Récupération de toutes les informations du produit sélectionné
      $produit = $this->em()
                      ->getRepository('CoreBundle:Produit')
                      ->findOneByNomPrd($prod);
      if (null === $prod) {
            throw new NotFoundHttpException("Le produit n'existe pas.");
        }
        // Récupération des contacts de l'USCAEP
      $contUn = $this->contactUnion();
      // On récupère la session de l'internaute
      $session = $request->getSession();

      // Si le panier n'existe pas, on l'initialise
      if (!$session->has('panier')) $session->set('panier', []);

      $panier = $session->get('panier');

      // Récupération de toutes les images du produit sélectionné
      $images = $this->em()
                   ->getRepository('CoreBundle:Image')
                   ->findBy(['produit' => $produit, 'onlImg' => true]);
      

      // Information pour l'internaute
      $this->get('session')->getFlashBag()
      ->add('commande', 'Cliquer sur "Ajouter" pour ajouter ce produit à votre commande');

        return $this->render('boutique/produit.html.twig',
                          ['panier' => $panier, 'produit' => $produit, 'images' => $images, 'contact' => $contUn]);
  }

    /**
     * @Route("/espace-publicitaire/ajouter/{id}", name="ajouter_produit")
     */
    public function ajouterAction(Request $request, $id)
    {
        // On récupère la session de l'internaute
        $session = $request->getSession();

        // Si le panier n'existe pas, on l'initialise
        if (!$session->has('panier')) $session->set('panier', []);

        $panier = $session->get('panier');

        if(array_key_exists($id, $panier))
        {

            if ($request->query->get('qte') != null) 
                $panier[$id] += $request->query->get('qte');

        }else{

            if ($request->query->get('qte') != null) 
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;
        }
         
        // Mise à jour du panier
        $session->set('panier', $panier);

        // Création du message d'information pour l'internaute
        $request->getSession()->getFlashBag()->add('success', 'Le produit a bien été ajouté !');

        // Rédirection vers l'accueil du site
        return $this->redirect($this->generateUrl('boutique'));
    }

    /**
     * @Route("/espace-publicitaire/supprimer/{id}", name="supprimer_produit")
     */
    public function supprimerAction(Request $request, $id)
	   {
		// On récupère la session de l'internaute
        $session = $request->getSession();

        $panier = $session->get('panier');

        if(array_key_exists($id, $panier))
        {
            unset($panier[$id]);
			   // Mise à jour du panier
        	$session->set('panier', $panier);

        	// Rédirection vers l'accueil du site
        	return $this->redirect($this->generateUrl('boutique')); 
        }else
     		// Rédirection vers l'accueil du site
        	return $this->redirect($this->generateUrl('boutique'));   	
	   }

     /**
     * @Route("/espace-publicitaire/soumettre-commande", name="checkout")
     */
    public function commanderAction(Request $request)
     {
        // On récupère la session de l'internaute
        $session = $request->getSession();
        // Récupération des contacts de l'USCAEP
        $contUn = $this->contactUnion();
        // Si le panier n'existe pas, on l'initialise
        if (!$session->has('panier')) $session->set('panier', []);

        $panier = $session->get('panier');

        // Liste des produits dans le panier
        $liste = $this->em()->getRepository('CoreBundle:Produit')
                  ->listePanier(array_keys($panier));

        // Information pour l'internaute
        $this->get('session')->getFlashBag()->add('commande', 'Vous pouvez faire vos commandes en toute quiétude !<br> Pour passer une commande, vous devez :
        <ul>
          <li>sélectionner le(s) produit(s) souhaités</li>
          <li>cliquer sur "Soumettre" pour remplir votre bon de commande</li>
        </ul>');

        // Initialisation  de la ligne de commande
        $lign_cmd = new Figurer();

        // Initialisons la commande
        $cmd = new Commande();

        $formClt = $this->get('form.factory')->create(CommandeType::class, $cmd);

        if ($request->isMethod('POST') && $formClt->handleRequest($request)->isValid()) {

            

            // Si la commande est finalisée, on l'enregistre en base de données
            $manager = $this->em();
            foreach ($panier as $key => $value ) {
                $produit = $this->em()
                        ->getRepository('CoreBundle:Produit')
                        ->findOneById($key);
                $produit->setStockPrd('ach', $value);
                $this->em()->getRepository('CoreBundle:Produit')
                        ->mettreJourStockProd($produit->getStockPrd(), $produit->getId());
            }
            // Attribuons la commande au client
            $cmd->setClient($clt);
            $this->em()->persist($cmd);
            $manager->flush();

            $request->getSession()->getFlashBag()->add('new-ach', 'Le bon de commande a bien été soumis');

            // Rédirection vers l'accueil du site
            return $this->redirectToRoute('homepage');
        }

        return $this->render('boutique/checkout.html.twig',
                          ['panier' => $panier, 'contact' => $contUn, 'form' => $formClt->createView(), 'listeProduits' => $liste]);    
     }
}