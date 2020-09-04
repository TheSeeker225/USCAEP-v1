<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use CoreBundle\Entity\Union_coop;
use CoreBundle\Entity\Image;
use CoreBundle\Entity\Administration;
use AppBundle\Entity\Client;
use CoreBundle\Entity\Produit;
use CoreBundle\Entity\Cooperative;
use CoreBundle\Entity\Region;
use CoreBundle\Entity\Departement;

use AppBundle\Form\ClientType;
use CoreBundle\Form\Union_coopType;
use CoreBundle\Form\ImageType;
use CoreBundle\Form\ProduitType;
use CoreBundle\Form\CooperativeType;
use CoreBundle\Form\RegionType;
use CoreBundle\Form\DepartementType;


class DefaultController extends Controller
{
    private function em()
    {
        return $this->getDoctrine()->getManager();
    }

    /*
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        // Sélection de l'occurence USCAEP
        $uscaep = $this->em()
                        ->getRepository('CoreBundle:Union_coop')
                        ->find(1);

        $list_prd = $this->em()
                         ->getRepository('CoreBundle:Produit')
                         ->findAll();

        $list_clt = $this->em()
                         ->getRepository('AppBundle:Client')
                         ->findAll();
        $list_coop = $this->em()
                         ->getRepository('CoreBundle:Cooperative')
                         ->findAll();
        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

      return $this->render('CoreBundle:default:index.html.twig',
                            ['uscaep' => $uscaep, 'produits' => $list_prd, 'clients' => $list_clt, 'cooperatives' => $list_coop, 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    // Actions sur les unions de coopératives
    /* Pour imprimer les informations ou supprimer l'union
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function aboutAction(Request $request, $id)
    {
        $uscaep = $this->em()
                    ->getRepository('CoreBundle:Union_coop')
                    ->find($id);
        if (null === $uscaep) {
            throw new NotFoundHttpException("Cette union n'existe pas.");
        }
        $image = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->findOneBy(['union_coop' => $uscaep, 'altImg' => "Logo de l'USCAEP"]);
                    // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $newImg = new Image();
        $formImg = $this->createForm(ImageType::class, $newImg);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->flush();

            return $this->redirectToRoute('core_homepage');
        }
        //$form = $this->get('form.factory')->create();

        

        // Validation du formulaire d'ajout d'image pour l'union
        if ($request->isMethod('POST') && $formImg->handleRequest($request)->isValid()) {
            
            $newImg->preUpload();
            $newImg->setUnionCoop($uscaep);
            $manager = $this->em();
            $manager->persist($newImg);
            $manager->flush();
            $newImg->upload($formImg, $uscaep->getSigleUn());

            return $this->redirectToRoute('core_homepage');
        }

        return $this->render('CoreBundle:Default:union/about.html.twig',
            ['uscaep' => $uscaep, 'image' => $image, 'formImg' => $formImg->createView(), 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    /* Pour modifier l'union
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function modUnAction(Request $request, $id)
    {
        $uscaep = $this->em()
                    ->getRepository('CoreBundle:Union_coop')
                    ->find($id);

        if (null === $uscaep) {
            throw new NotFoundHttpException("Cette union n'existe pas.");
        }

        $formSupp = $this->get('form.factory')->create();

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();

        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $form = $this->createForm(Union_coopType::class, $uscaep);

        // Validation du formulaire de suppression
        if ($request->isMethod('POST') && $formSupp->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->remove($uscaep);
            $manager->flush();

            return $this->redirectToRoute('core_homepage');
        }

        // Validation du formulaire de modification
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->flush();

            return $this->redirectToRoute('core_homepage');
        }

        return $this->render('CoreBundle:Default:union/form_un.html.twig',
            ['uscaep' => $uscaep, 'form' => $form->createView(), 'formSupp' => $formSupp->createView(), 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    # Méthodes pour les produits
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function produitAction(Request $request)
    {
        $list_prd = $this->em()
                         ->getRepository('CoreBundle:Produit')
                         ->findAll();

        $produit = new Produit();

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();

        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $form = $this->createForm(ProduitType::class, $produit);

        // Validation du formulaire pour ajouter le produit
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->persist($produit);
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('prd-success', 'Le produit a été enregisté');

            return $this->redirectToRoute('core_produit');
        }

        return $this->render('CoreBundle:Gestion:produits/produit.html.twig',
                            ['produits' => $list_prd, 'form' => $form->createView(), 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }
        
    // Modification d'un produit
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function modprodAction(Request $request, $prod)
    {
        $produit = $this->em()
                        ->getRepository('CoreBundle:Produit')
                        ->findOneByNomPrd($prod);

        if (null === $produit) {
            throw new NotFoundHttpException("Ce produit n'existe pas.");
        }
        $image = $this->em()
                        ->getRepository('CoreBundle:Image')
                        ->findOneByAltImg($produit->getNomPrd());
        $sliders = $this->em()
                        ->getRepository('CoreBundle:Image')
                        ->findByProduit($produit);

                        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();

        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $form = $this->createForm(ProduitType::class, $produit);

        $newImg = new Image();
        $formImg = $this->createForm(ImageType::class, $newImg);

        // Validation du formulaire pour modifier le produit
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('mod-success', 'Le produit a été modifié');

            return $this->redirectToRoute('core_produit_mod', ['prod' => $produit->getNomPrd()]);
        }

        // Validation du formulaire d'ajout d'image pour l'union
        if ($request->isMethod('POST') && $formImg->handleRequest($request)->isValid()) {
            
            $newImg->preUpload();
            $newImg->setProduit($produit);
            $manager = $this->em();
            $manager->persist($newImg);
            $manager->flush();
            $newImg->upload($formImg, $produit->getNomPrd());

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('mod-success', 'L\'image a été ajoutée');

            return $this->redirectToRoute('core_produit_mod', ['prod' => $produit->getNomPrd()]);
        }


        return $this->render('CoreBundle:Gestion:produits/modprod.html.twig',
                             ['formImg' => $formImg->createView(), 'form' => $form->createView(), 'produit' => $produit, 'image' => $image, 'sliders' => $sliders, 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
    }
        // Suppression d'un produit
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function suppprodAction(Request $request, $prod)
    {
        $produit = $this->em()
                        ->getRepository('CoreBundle:Produit')
                        ->findOneByNomPrd($prod);
        if (null === $produit) {
            throw new NotFoundHttpException("Ce produit n'existe pas.");
        }
        $image = $this->em()
                        ->getRepository('CoreBundle:Image')
                        ->findOneByAltImg($produit->getNomPrd());
        $sliders = $this->em()
                        ->getRepository('CoreBundle:Image')
                        ->findByProduit($produit);

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $form = $this->get('form.factory')->create();
        // Validation du formulaire pour supprimer le produit
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->remove($produit);
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('supp-success', 'Le produit a été modifié');

            return $this->redirectToRoute('core_produit');
        }

        return $this->render('CoreBundle:Gestion:produits/suppprod.html.twig',
                             ['form' => $form->createView(), 'produit' => $produit, 'image' => $image, 'sliders' => $sliders, 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
    }

    // Actions sur les coopératives
            // Obtenir la liste des coopératives
    /*
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function coopAction(Request $request)
    {
        $list_coop = $this->em()
                         ->getRepository('CoreBundle:Cooperative')
                         ->findAll();


        $maCoop = new Cooperative();
        $nwDep = new Departement();
        $nwReg = new Region();

        $form = $this->createForm(CooperativeType::class, $maCoop);
        $formDep = $this->createForm(DepartementType::class, $nwDep);
        $formReg = $this->createForm(RegionType::class, $nwReg);

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        // Validation du formulaire d'ajout de coopérative
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->persist($maCoop);
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('add-success', 'La coopérative a été ajoutée');

            return $this->redirectToRoute('core_coop');
        }

        // Validation du formulaire d'ajout du département
        if ($request->isMethod('POST') && $formDep->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->persist($nwDep);
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('add-success', 'Le département a été ajouté');

            return $this->redirectToRoute('core_coop');
        }

        // Validation du formulaire d'ajout de la region
        if ($request->isMethod('POST') && $formReg->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->persist($nwReg);
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('add-success', 'La région a été ajoutée');

            return $this->redirectToRoute('core_coop');
        }

        return $this->render('CoreBundle:Default:cooperatives/local.html.twig',
                            ['cooperatives' => $list_coop, 'form' => $form->createView(), 'formDep' => $formDep->createView(), 'formReg' => $formReg->createView(), 'alertMail' => $alertMail, 'alertApp' => $alertApp]);
    }
            // Pour voir une seule coopérative
    /*
    * @Security("has_role('ROLE_USER')")
    */
    public function voircoopAction(Request $request, $coop)
    {
        // Récupération de la copérative
        $maCoop = $this->em()->getRepository('CoreBundle:Cooperative')->findOneBySigleCoop($coop);
        
        if (null === $maCoop) {
            throw new NotFoundHttpException("Cette cooperative n'existe pas.");
        }
        $newImg = new Image();
        $formImg = $this->createForm(ImageType::class, $newImg);

          // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $employes = $this->em()
                        ->getRepository('CoreBundle:User')
                        ->findByCooperative($maCoop);

        $membres = $this->em()
                        ->getRepository('CoreBundle:Membre')
                        ->findByCooperative($maCoop);

        $sliders = $this->em()
                        ->getRepository('CoreBundle:Image')
                        ->findByCooperative($maCoop);

        $form = $this->createForm(CooperativeType::class, $maCoop);

        // Validation du formulaire de modification de la coopérative
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('mod-success', 'La coopérative a été modifiée');

            return $this->redirectToRoute('core_coop_view', ['coop' => $maCoop->getSigleCoop(), 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
        }

        // Validation du formulaire d'ajout d'image pour la coopérative
        if ($request->isMethod('POST') && $formImg->handleRequest($request)->isValid()) {
            
            $newImg->preUpload();
            $newImg->setCooperative($maCoop);
            $manager = $this->em();
            $manager->persist($newImg);
            $manager->flush();
            $newImg->upload($formImg, $maCoop->getSigleCoop());

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('img-success', 'L\'image a été ajoutée');

            return $this->redirectToRoute('core_coop_view', ['coop' => $maCoop->getSigleCoop()]);
        }

        return $this->render('CoreBundle:Default:cooperatives/voircoop.html.twig',
                            ['maCoop' => $maCoop, 'form' => $form->createView(), 'formImg' => $formImg->createView(), 'sliders' => $sliders, 'alertMail' => $alertMail , 'alertApp' => $alertApp, 'membres' => $membres, 'employes' => $employes]);
    }
        // Suppression d'une coopérative
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function suppcoopAction(Request $request, $coop)
    {
        $maCoop = $this->em()
                        ->getRepository('CoreBundle:Cooperative')
                        ->findOneBySigleCoop($coop);
        if (null === $maCoop) {
            throw new NotFoundHttpException("Cette cooperative n'existe pas.");
        }
        $sliders = $this->em()
                        ->getRepository('CoreBundle:Image')
                        ->findByCooperative($maCoop);

                        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $form = $this->get('form.factory')->create();
        // Validation du formulaire pour supprimer la coopérative
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->remove($maCoop);
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('supp-success', 'La coopérative a été modifiée');

            return $this->redirectToRoute('core_coop');
        }

        return $this->render('CoreBundle:Default:cooperatives/suppcoop.html.twig',
                             ['coop' => $maCoop, 'image' => null, 'sliders' => $sliders, 'form' => $form->createView(), 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
    }

    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function emploiAction()
    {
        return $this->render('CoreBundle:Default:cooperative/employe.html.twig');
    }

    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function transAction()
    {
        // Liste des livraisons en cours
        $livraisons = $this->em()->getRepository('CoreBundle:Livraison')->findAll();
        // Liste des livraisons en cours
        $commandes = $this->em()->getRepository('AppBundle:Commande')->findAll();
        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        return $this->render('CoreBundle:Gestion:transactions/trans.html.twig', ['alertMail' => $alertMail, 'alertApp' => $alertApp, 'commandes' => $commandes, 'livraisons' => $livraisons]);
    }

    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function viewTransAction(Request $request, $id)
    {
        // Récupération de la livraison
        $commande = $this->em()->getRepository('AppBundle:Commande')->findOneById($id);
        
        if (null === $commande) {
            throw new NotFoundHttpException("Cette commande n'existe pas.");
        }

        $infoUn = $this->em()
                     ->getRepository('CoreBundle:Union_coop')
                     ->find(1);
        $image = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->findOneBy(['altImg' => "Logo de l'USCAEP"]);

                    // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        return $this->render('CoreBundle:Gestion:transactions/viewtrans.html.twig', 
                            ['uscaep' => $infoUn, 'image' => $image, 'alertMail' => $alertMail , 'alertApp' => $alertApp, 'commande' => $commande]);
    }

    # Méthodes pour les clients
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function clientAction()
    {
        $clients = $this->em()
                        ->getRepository('AppBundle:Client')
                        ->findAll();
        $client = new Client();
                        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        $form = $this->createForm(ClientType::class, $client);
        return $this->render('CoreBundle:Gestion:clients/client.html.twig', ['clients' => $clients, 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
    }

        // Modification d'un client
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function modcltAction($id)
    {
        $client = $this->em()
                        ->getRepository('AppBundle:Client')
                        ->find($id);
        if (null === $client) {
            throw new NotFoundHttpException("Ce client n'existe pas.");
        }

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        $form = $this->createForm(ClientType::class, $client);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->remove($client);
            $manager->flush();

            return $this->redirectToRoute('core_client_mod');
        }


        return $this->render('CoreBundle:Gestion:clients/modclt.html.twig',
                             ['form' => $form->createView(), 'client' => $client, 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
    }

        // Suppression d'un client
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function suppcltAction($id)
    {
        $client = $this->em()
                        ->getRepository('AppBundle:Client')
                        ->find($id);

        if (null === $client) {
            throw new NotFoundHttpException("Ce client n'existe pas.");
        }

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $form = $this->createForm(ClientType::class, $client);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->remove($client);
            $manager->flush();

            return $this->redirectToRoute('core_client');
        }


        return $this->render('CoreBundle:Gestion:clients/suppclt.html.twig',
                             ['form' => $form->createView(), 'client' => $client, 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
    }

    # Méthodes pour les images
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function imageAction(Request $request)
    {
        $list_img = $this->em()
            ->getRepository('CoreBundle:Image')
            ->findAll();
        $newImg = new Image();
        $formImg = $this->createForm(ImageType::class, $newImg);

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        // Validation du formulaire d'ajout d'image
        if ($request->isMethod('POST') && $formImg->handleRequest($request)->isValid()) {
            
            $newImg->preUpload();
            $manager = $this->em();
            $manager->persist($newImg);
            $manager->flush();
            $newImg->upload($formImg, null);

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('success', 'L\'image a été enregistée');

            return $this->redirectToRoute('core_image');
        }

        return $this->render('CoreBundle:Gestion:images/image.html.twig',
            ['images' => $list_img, 'formImg' => $formImg->createView(), 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
    }
    
    // Modification d'une image
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function modimgAction(Request $request, $dir, $img)
    {
        $image = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->findOneBy(['dirImg' => $dir, 'id' => $img]);
        if (null === $image) {
            throw new NotFoundHttpException("Cette image n'existe pas.");
        }
        $formImg = $this->createForm(ImageType::class, $image);

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        if ($request->isMethod('POST') && $formImg->handleRequest($request)->isValid()) {
            
            $manager = $this->em();
            $manager->flush();

            // Création du message d'information pour l'internaute
            $request->getSession()->getFlashBag()->add('success', 'L\'image a été modifiée');

            return $this->redirectToRoute('core_image');
        }

        return $this->render('CoreBundle:Gestion:images/modimg.html.twig',
            ['image' => $image, 'formImg' => $formImg->createView(), 'alertMail' => $alertMail, 'alertApp' => $alertApp]);
    }
        // Suppression d'une image
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function suppimgAction(Request $request, $dir, $img)
    {
        $image = $this->em()
                    ->getRepository('CoreBundle:Image')
                    ->findOneBy(['dirImg' => $dir, 'id' => $img]);
        if (null === $image) {
            throw new NotFoundHttpException("Cette image n'existe pas.");
        }
        $form = $this->get('form.factory')->create();

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $image->preRemoveUpload();
            $manager = $this->em();
            $manager->remove($image);
            $manager->flush();
            $image->removeUpload();

            // Création du message d'information pour l'internaute
            $request->getSession()->getFlashBag()->add('del-success', 'L\'image a été modifiée');

            return $this->redirectToRoute('core_image');
        }

        return $this->render('CoreBundle:Gestion:images/suppimg.html.twig',
            ['image' => $image, 'form' => $form->createView(), 'alertApp' => $alertApp , 'alertMail' => $alertMail]);
    }

    # Méthodes pour les messages
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function inboxAction()
    {
        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        return $this->render('CoreBundle:Gestion:mail/inbox.html.twig', ['alertApp' => $alertApp, "alertMail" => $alertMail]);
    }

    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function readAction(Request $request)
    {
        $id = $request->query->get('id');
        $message = $this->em()->getRepository('AppBundle:Message')->findOneById($id);
        if (null === $message) {
            throw new NotFoundHttpException("Ce message n'existe pas.");
        }

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        return $this->render('CoreBundle:Gestion:mail/read.html.twig', ['alertApp' => $alertApp, "alertMail" => $alertMail, 'message' => $message]);
    }

    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function composeAction()
    {
        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        return $this->render('CoreBundle:Gestion:mail/compose.html.twig', ['alertApp' => $alertApp, "alertMail" => $alertMail, 'message' => $message]);
    }

    #Méthodes pour les utlisateurs
    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function listusersAction()
    {
        $users = $this->em()->getRepository('CoreBundle:User')->findAll();

        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        return $this->render('CoreBundle:Gestion:user/listusers.html.twig',
                            ['users' => $users, "alertApp" => $alertApp, "alertMail" => $alertMail]);
    }

    /*
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function viewuserAction(Request $request, $key)
    {
        if ($key == true) {
            // Création du message d'information pour l'internaute
            $request->getSession()->getFlashBag()->add('alert', 'Veuillez revérifier les informations avant de le <a href="#" data-toggle="modal" data-target=".bs-delUser" class="alert-link">supprimer</a> !');
        }
        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        
        return $this->render('CoreBundle:Gestion:user/viewuser.html.twig',
                            ['key' => $key, "alertApp" => $alertApp, "alertMail" => $alertMail]);
    }

    /*
    * @Security("has_role('ROLE_USER')")
    */
    public function profilAction()
    {
        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        return $this->render('CoreBundle:Gestion:user/profile.html.twig', ["alertApp" => $alertApp, "alertMail" => $alertMail]);
    }

    /*
    * @Security("has_role('ROLE_USER')")
    */
    public function aproposAction()
    {
        // Liste des messages
        $alertMail = $this->em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');
        return $this->render('CoreBundle:Gestion:help/about.html.twig', ["alertApp" => $alertApp, "alertMail" => $alertMail]);
    }

}

