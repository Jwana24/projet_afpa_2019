<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/accueil")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="accueil", methods="GET|POST")
     */
    public function list(SessionInterface $session, ArticlesRepository $articlesRepository, Request $request): Response
    {
        return $this->render('general/index.html.twig', [
            'articles' => $articlesRepository->last_articles(),
            'user' => $this->getUser(),
            'last_path' => 'accueil'
        ]);
    }
}