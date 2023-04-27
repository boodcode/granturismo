<?php

namespace App\Controller;

use App\Entity\User;
use App\Validator\Constraints\ConstraintsPassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
     public function index(AuthenticationUtils $authenticationUtils): Response
    {
        /**
         * If the user has already logged in (marked as is authenticated fully by symfony's security)
         * then redirect this user back (in my case, to the dashboard, which is the main entry for
         * my logged in users)
         */
        //if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
         if($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }



        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

}
