<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use App\Form\LanguageType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/accueil")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="accueil", methods="GET|POST")
     */
    public function list(ArticlesRepository $articlesRepository, Request $request): Response
    {
        $form = $this->createForm(LanguageType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $locale = $form->getData()['locale'];
            $user = $this->getUser();
            $user->setLOcale($locale);
            $em->persist($user);
            $em->flush();
        }

        return $this->render('general/index.html.twig', [
            'articles' => $articlesRepository->last_articles(),
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }
}