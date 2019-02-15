<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use App\Form\ContactType;
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
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = (new \Swift_Message('Quelqu\'un vous a contacté via le site'))
                    ->setFrom($form['mail']->getData())
                    ->setTo('contact@exemple.com')
                    ->setBody(
                        $this->renderView(
                            'emails/contact.html.twig',
                            [
                                'lastname' => $form['lastname']->getData(),
                                'firstname' => $form['firstname']->getData(),
                                'mail' => $form['mail']->getData(),
                                'message' => $form['message']->getData()
                            ]
                        ),
                        'text/html'
                    );

                $mailer->send($message);
        }

        return $this->render('general/index.html.twig', [
            'articles' => $articlesRepository->last_articles(),
            'last_path' => 'accueil',
            'form' => $form->createView()
        ]);
    }
}