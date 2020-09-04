<?php

namespace GestPlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use CoreBundle\Entity\Membre;
use CoreBundle\Entity\User;
use CoreBundle\Entity\Cooperative;

use CoreBundle\Entity\Image;

use CoreBundle\Form\ImageType;
use CoreBundle\Form\CooperativeType;
use CoreBundle\Form\DepartementType;
use CoreBundle\Form\MembreType;
use CoreBundle\Form\UserType;

class DefaultController extends Controller
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
     * @param int  $id
     * 
     * @return Cooperative
     */
    private function getCooperative($id)
    {
      return $this->_em()->getRepository('CoreBundle:Cooperative')->findOneById($id);
    }

    // Tableau de bord du gestionnaire
    /*
    * @Security("has_role('ROLE_USER')")
    */
    /**
     * IndexAction gère le tableau de bord du poste de gestion
     * 
     * @return render
     */
    public function indexAction()
    {
     
        $maCoop = $this->getCooperative(1);

        $employes = $this->_em()->getRepository('CoreBundle:User')->findByCooperative($maCoop);

        $producteurs = $this->_em()->getRepository('CoreBundle:Membre')->findByCooperative($maCoop);

        $livraisons = $this->_em()
                    ->getRepository('CoreBundle:Livraison')
                    ->livraisonsParCooperative($maCoop);

                    // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        return $this->render('GestPlatformBundle:Default:index.html.twig',
                    ['maCoop' => $maCoop, 'employes' => $employes, 'producteurs' => $producteurs, 'livraisons' => $livraisons, 'alertApp' => $alertApp , 'alertMail' => $alertMail]);
    }


    // Plus de détails sur la coopérative
    /*
    * @Security("has_role('ROLE_USER')")
    */
    public function voircoopAction(Request $request, $coop)
    {
        // Récupération de la copérative
        $maCoop = $this->_em()->getRepository('CoreBundle:Cooperative')->findOneBySigleCoop($coop);
        
        if (null === $maCoop) {
            throw new NotFoundHttpException("Cette cooperative n'existe pas.");
        }
        $newImg = new Image();
        $formImg = $this->createForm(ImageType::class, $newImg);

          // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $employes = $this->_em()
                        ->getRepository('CoreBundle:User')
                        ->findByCooperative($maCoop);

        $membres = $this->_em()
                        ->getRepository('CoreBundle:Membre')
                        ->findByCooperative($maCoop);

        $sliders = $this->_em()
                        ->getRepository('CoreBundle:Image')
                        ->findByCooperative($maCoop);

        $form = $this->createForm(CooperativeType::class, $maCoop);

        // Validation du formulaire de modification de la coopérative
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $manager = $this->_em();
            $manager->flush();

            // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('mod-success', 'La coopérative a été modifiée');

            return $this->redirectToRoute('core_coop_view', ['coop' => $maCoop->getSigleCoop(), 'alertMail' => $alertMail , 'alertApp' => $alertApp]);
        }

        // Validation du formulaire d'ajout d'image pour la coopérative
        if ($request->isMethod('POST') && $formImg->handleRequest($request)->isValid()) {
            
            $newImg->preUpload();
            $newImg->setCooperative($maCoop);
            $manager = $this->_em();
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

    // Ajouter un employe
    /*
     * @Security("has_role('ROLE_USER')")
     */
    public function empAction(Request $request)
    {
        // Récupération de la coopérative
        $maCoop = $this->_em()->getRepository('CoreBundle:Cooperative')->findOneBySigleCoop('UGPC');

        if (null === $maCoop) {
            throw new NotFoundHttpException("Cette cooperative n'existe pas.");
        }

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $employes = $this->_em()->getRepository('CoreBundle:User')->findByCooperative($maCoop);
        $employe = new User();

        $formEmp = $this->createForm(UserType::class, $employe)
                        ->remove('username')
                        ->remove('password')
                        ->remove('isActive')
                        ->remove('salt')
                        ->remove('roles')
                        ->remove('cooperative')
                        ->remove('union_coop');


        if ($request->isMethod('POST') && $formEmp->handleRequest($request)->isValid()) {
            $manager = $this->_em();
            $employe->setCooperative($maCoop);
            $manager->persist($employe);
            $manager->flush();

            $request->getSession()->getFlashBag()->add('add-emp', 'L\'employe a été enregistré');

            return $this->redirectToRoute('gest_platform_emp');
        }

        return $this->render('GestPlatformBundle:employes:emp.html.twig', 
                            ['maCoop' => $maCoop, 'formEmp' => $formEmp->createView(), 'employes' => $employes, 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    // Plus de détails sur un employe
    /*
    * @Security("has_role('ROLE_USER')")
    */
    public function modEmpAction(Request $request, $id)
    {
        $employe = $this->_em()->getRepository('CoreBundle:User')->findOneById($id);
        if (null === $employe) {
            throw new NotFoundHttpException("Cet employé n'existe pas.");
        }

        // Récupération de la coopérative
        $maCoop = $this->_em()->getRepository('CoreBundle:Cooperative')->findOneBySigleCoop('UGPC');

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $formEmp = $this->createForm(UserType::class, $employe)
                        ->remove('username')
                        ->remove('password')
                        ->remove('isActive')
                        ->remove('salt')
                        ->remove('roles')
                        ->remove('cooperative')
                        ->remove('union_coop');

        // Validation du formulaire de modification d'un employé
        if ($request->isMethod('POST') && $formEmp->handleRequest($request)->isValid()) {
            $manager = $this->_em();
            $manager->flush();

            $request->getSession()->getFlashBag()->add('mod-emp', 'Les informations ont été modifiées');

            return $this->redirectToRoute('gest_platform_emp_mod', ['id' => $employe->getId()]);
        }

        return $this->render('GestPlatformBundle:employes:view_emp.html.twig', 
        ['maCoop' => $maCoop, 'employe' => $employe, 'formEmp' => $formEmp->createView(), 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    // Ajouter un membre
    /*
    * @Security("has_role('ROLE_USER')")
    */
    public function memAction(Request $request)
    {
        // Récupération de la coopérative
        $maCoop = $this->getCooperative(1);

        if (null === $maCoop) {
            throw new NotFoundHttpException("Cette cooperative n'existe pas.");
        }

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $membres = $this->_em()->getRepository('CoreBundle:Membre')->findByCooperative($maCoop);
        $membre = new Membre();

        $formMem = $this->createForm(MembreType::class, $membre);

        if ($request->isMethod('POST') && $formMem->handleRequest($request)->isValid()) {
            
            $manager = $this->_em();
            $membre->setCooperative($maCoop);
            $manager->persist($membre);
            $manager->flush();

            $request->getSession()->getFlashBag()->add('add-mem', 'Le producteur a été enregistré');

            return $this->redirectToRoute('gest_platform_mem');
        }

        return $this->render('GestPlatformBundle:membres:mem.html.twig', 
                            ['membres' => $membres, 'maCoop' => $maCoop, 'formMem' => $formMem->createView(), 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    // Plus de détails sur un membre
    /*
    * @Security("has_role('ROLE_USER')")    */
    public function modMemAction(Request $request, $id)
    {
        $producteur = $this->_em()->getRepository('CoreBundle:Membre')->findOneById($id);

        if (null === $producteur) {
            throw new NotFoundHttpException("Ce producteur n'existe pas.");
        }

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $formMem = $this->createForm(MembreType::class, $producteur);

        $maCoop = $this->getCooperative(1);

        if ($request->isMethod('POST') && $formMem->handleRequest($request)->isValid()) {
            $manager = $this->_em();
            $manager->flush();

            $request->getSession()->getFlashBag()->add('mod-mem', 'Les informations ont été modifiées');

            return $this->redirectToRoute('gest_platform_mem_view', ['id' => $id]);
        }

        return $this->render('GestPlatformBundle:membres:view_mem.html.twig',
                            ['maCoop' => $maCoop, 'producteur' => $producteur, 'formMem' => $formMem->createView(), 'alertApp' => $alertApp, 'alertMail' => $alertMail]);
    }

    // Informations sur l'internaute
    /*
    * @Security("has_role('ROLE_USER')")
    */
    public function profilAction(Request $request, $id)
    {
        $maCoop = $this->getCooperative(1);
        $internaute = $this->_em()->getRepository('CoreBundle:User')->findOneBy(['cooperative' => $maCoop, 'id' => $id]);

        if (null === $internaute) {
            throw new NotFoundHttpException("Vous n'êtes pas de cette coopérative.");
        }

        // Liste des messages
        $alertMail = $this->_em()->getRepository('AppBundle:Message')->findAll();
        // Liste des livraisons en cours
        $alertApp = $this->_em()->getRepository('CoreBundle:Livraison')->livraisonsEnCours('AN');

        $formEmp = $this->createForm(UserType::class, $internaute)
                        ->remove('username')
                        ->remove('password')
                        ->remove('isActive')
                        ->remove('salt')
                        ->remove('roles')
                        ->remove('cooperative')
                        ->remove('union_coop');

        if ($request->isMethod('POST') && $formEmp->handleRequest($request)->isValid()) {
            $manager = $this->_em();
            $manager->flush();

            $request->getSession()->getFlashBag()->add('mod-mem', 'Les informations ont été modifiées');

            return $this->redirectToRoute('gest_platform_profil', ['id' => $id]);
        }

        return $this->render('CoreBundle:user:profile.html.twig', ['alertApp' => $alertApp, 'alertMail' => $alertMail, 'maCoop' => $maCoop, 'formEmp' => $formEmp->createView()]);
    }
}
