<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * @Route("/accueil")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="accueil", methods={"GET"})
     */
    public function list(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('general/index.html.twig', [
            'articles' => $articlesRepository->last_articles(),
            'user' => $this->getUser()
        ]);
    }
}