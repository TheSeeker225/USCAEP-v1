<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CoreBundle\Entity\User;
use CoreBundle\Entity\Image;
use CoreBundle\Entity\Union_coop;
use CoreBundle\Entity\Cooperative;

class SecurityController extends Controller
{
  
  /**
   * @Route("/login", name="login")
   */
  public function loginAction(Request $request)
  {
    
      // 001/17/01/18/ADM et adminpass
      // 002/17/01/18/USR et userpass

      // Si le visiteur est déjà authentifié, on le redirigera
      if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) 
      {
          
          /* Cependant, il faudra savoir s'il est un gestionnaire ou l'administrateur 
          afin de le rediriger dans l'espace adéquat */
        $route = ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) ? 'core_homepage' : 'gest_platform_homepage' ;

          return $this->redirectToRoute($route);

      } else {
        
          $authenticationUtils = $this->get('security.authentication_utils');

          $error = $authenticationUtils->getLastAuthenticationError();

          $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('security/login.html.twig', 
                        ['last_username' => $lastUsername, 'error' => $error]);
      }
  }

  /**
   * @Route("/logout", name="logout")
   */
  public function logoutAction(Request $request)
  {

    return $this->render('security/logout.html.twig');
  }

}

  