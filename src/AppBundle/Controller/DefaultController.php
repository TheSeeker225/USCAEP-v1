<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Message;

use CoreBundle\Entity\Union_coop;
use CoreBundle\Entity\Image;

use AppBundle\Form\MessageType;
use CoreBundle\Form\ProduitType;


class DefaultController extends Controller
{
    private function _em()
    {
        return $this->getDoctrine()->getManager();
    }

    private function contactUnion()
    {
        return $this->_em()->getRepository('CoreBundle:Union_coop')->recupererContactUnion();
    } 

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
      {
        $contUn = $this->contactUnion();

        $partenaires = $this->_em()
                    ->getRepository('CoreBundle:Image')
                    ->listePartenaires();
        $cooperatives = $this->_em()
                    ->getRepository('CoreBundle:Cooperative')
                    ->findAll();
        $activites = $this->_em()
                    ->getRepository('CoreBundle:Image')
                    ->listeActivites();
        $sliders = $this->_em()
                    ->getRepository('CoreBundle:Image')
                    ->listeSliders();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', 
          ['sliders' => $sliders, 'activites' => $activites, 'cooperatives' => $cooperatives, 'partenaires' => $partenaires, 'contact' => $contUn]);
      }

    /**
     * @Route("/a-propos", name="about")
     */
    public function aboutAction(Request $request)
      {
        $contUn = $this->contactUnion();

        $infoUn = $this->_em()
                     ->getRepository('CoreBundle:Union_coop')
                     ->choisirUnion();
        $image = $this->_em()
                    ->getRepository('CoreBundle:Image')
                    ->findOneBy(['union_coop' => $infoUn, 'altImg' => "Logo de l'USCAEP"]);

        return $this->render('default/about.html.twig',
                          ['image' => $image, 'uscaep' => $infoUn, 'contact' => $contUn]);
      }

      /**
     * @Route("/nos-contacts", name="contacts")
     */
    public function contactAction(Request $request)
    {
      $this->get('session')->getFlashBag()->add('info', 'Ces contacts sont accessibles !');

      $message = new Message();
      $form = $this->createForm(MessageType::class, $message);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $manager = $this->_em();
            $manager->persist($message);
            $manager->flush();

          // Création du message d'information pour l'internaute
          $request->getSession()->getFlashBag()->add('success', 'Votre message a été bien envoyé !');

          // Rédirection vers l'accueil du site
          return $this->redirectToRoute('homepage');
        }

      $contUn = $this->contactUnion();

      return $this->render('default/contact.html.twig',
                          ['contact' => $contUn, 'form' => $form->createView()]);
    }

    /**
     * @Route("/nos-coopératives/", name="liste_cooperatives")
     */
    public function cooperativeAction()
      { 
        $contUn = $this->contactUnion();

        $cooperatives = $this->_em()
                    ->getRepository('CoreBundle:Cooperative')
                    ->findAll();

        return $this->render('cooperatives/coop.html.twig', 
                      ['contact' => $contUn, 'cooperatives' => $cooperatives]);
      }

  /**
   * @Route("/nos-coopératives/{coop}", name="details_cooperative")
   */
  public function voircoopAction($coop)
    {
      $contUn = $this->contactUnion();

      $coop = $this->_em()->getRepository('CoreBundle:Cooperative')->findOneBySigleCoop($coop);
      if (null === $coop) {
            throw new NotFoundHttpException("Cette cooperative n'existe pas.");
        }
      $sliders = $this->_em()
                        ->getRepository('CoreBundle:Image')
                        ->findByCooperative($coop);

      return $this->render('cooperatives/voircoop.html.twig',
                           ['coop' => $coop, 'contact' => $contUn, 'sliders' => $sliders]);
    }

  /**
   * @Route("/nos-activités", name="liste_activites")
   */
  public function activAction()
    {
      $contUn = $this->contactUnion();

      // Récupération des produits disponibles
        $cultures = $this->_em()
                    ->getRepository('CoreBundle:Image')
                    ->listeParDomaine("Agriculture");
        $animals = $this->_em()
                    ->getRepository('CoreBundle:Image')
                    ->listeParDomaine("Elévage");
        $derives = $this->_em()
                    ->getRepository('CoreBundle:Image')
                    ->listeParDomaine("Transformation");

      return $this->render('activites/activ.html.twig',
                          ['cultures' => $cultures, 'animals' => $animals, 'derives' => $derives, 'contact' => $contUn]);
    }
   
  /**
   * @Route("/agriculture/{culture}", name="details_culture")
   */
  public function agriAction($culture)
    {
      
      $produit = $this->_em()
                      ->getRepository('CoreBundle:Produit')
                      ->findOneByNomPrd($culture);
      if (null === $produit) {
            throw new NotFoundHttpException("Cette culture n'existe pas.");
        }

      $contUn = $this->contactUnion();
      $sliders = $this->_em()
                        ->getRepository('CoreBundle:Image')
                        ->findBy(['produit' => $produit, 'onlImg' => true]);

        return $this->render('activites/agri.html.twig',
            ['culture' => $produit, 'sliders' => $sliders, 'contact' => $contUn]);
    }

  /**
   * @Route("/élévage/{animal}", name="details_animal")
   */
  public function elevAction($animal = 'escargot')
  {
      $animal = $this->_em()->getRepository('CoreBundle:Produit')->findOneByNomPrd($animal);
      if (null === $animal) {
            throw new NotFoundHttpException("L'animal n'existe pas.");
        }

      $contUn = $this->contactUnion();

      return $this->render('activites/elev.html.twig',
                          [ 'animal' => $animal, 'contact' => $contUn]);
  }

}

  