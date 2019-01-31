<?php

namespace App\Controller\Admin\Security;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();

        $lastUsername = $utils->getLastUsername();
        $this->addFlash('success', 'Vous êtes connecté');

        return $this->render('Admin/Security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'last_path' => 'login'
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }
}