<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use App\Form\ContactType;
use App\Repository\PostsRepository;
use App\Repository\MembersRepository;
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
    public function list(SessionInterface $session, ArticlesRepository $articlesRepository, PostsRepository $postRepository,MembersRepository $memberRepository, Request $request, \Swift_Mailer $mailer): Response
    {
        foreach($memberRepository->findBy(['statut' => 'delete']) as $member)
        {
            $postRepository->setNullById($member->getId());
            $memberManager = $this->getDoctrine()->getManager();
            $memberManager->remove($member);
            $memberManager->flush();
            $this->addFlash('success', 'Votre compte a bien été supprimé');
        }

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $errors = [];

            if(!preg_match('#^[a-zA-Z \-]{5,50}$#', $form['lastname']->getData()))
            {
                $errors[] = 'Votre nom n\'est pas valide, il ne doit contenir aucun accent';
            }

            if(!preg_match('#^[a-zA-Z \-àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]{5,50}$#', $form['firstname']->getData()))
            {
                $errors[] = 'Votre prénom n\'est pas valide';
            }

            if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,5}$#', $form['mail']->getData()))
            {
                $errors[] = 'Votre email n\'est pas valide';
            }

            if(count($errors) == 0)
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
                $this->addFlash('success', 'Votre message a bien été envoyé');
                return $this->redirectToRoute('accueil');
            }
            else
            {
                foreach($errors as $error)
                {
                    $this->addFlash('error', $error);
                }
            }
        }

        return $this->render('general/index.html.twig', [
            'articles' => $articlesRepository->last_articles(),
            'last_path' => 'accueil',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mentionslegales", name="mentionslegales")
     */
    public function mentionsLegales(): Response
    {
        setcookie('cookie-bandeauCookie', 'myseconddata', time() + 32140800, "/");

        return $this->render('general/mentionslegales.html.twig', [
            'last_path' => 'mentionslegales'
        ]);
    }
}