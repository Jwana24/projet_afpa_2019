<?php

namespace App\Controller\Admin\Security;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        // Get errors when the user logs in
        $error = $utils->getLastAuthenticationError();

        // Get the username of the last connected user
        $lastUsername = $utils->getLastUsername();

        // Create a flash message if the connection is a success
        $this->addFlash('success', 'Vous êtes connecté');

        // Get the view Twig 'login.html.twig' bound to this code and send variables (error, last_username and last_path)
        return $this->render('Admin/Security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            // Stock the route of the current page
            'last_path' => 'login'
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        // Symfony manage the log out, the function must just appear
    }
}