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
    public function index(SessionInterface $session, ArticlesRepository $articlesRepository, PostsRepository $postRepository,MembersRepository $memberRepository, Request $request, \Swift_Mailer $mailer): Response
    {
        // We cannot delete a connected member, we change the member's status on 'delete', we disconnect the member and redirect on the homepage
        // We create a foreach to browse members who have the 'delete' status
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

            // We verify the validity of the fields with Regex
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
                // We use the library Swift Mailer to create a message with Swift Message object
                $message = (new \Swift_Message('Quelqu\'un vous a contacté via le site'))
                        ->setFrom($form['mail']->getData())
                        ->setTo('contact@exemple.com')
                        ->setBody(
                            $this->renderView(
                                // We get the informations send in the contacts form, and we send it in the twig view to generate the body of the mail
                                'emails/contact.html.twig',
                                [
                                    'lastname' => $form['lastname']->getData(),
                                    'firstname' => $form['firstname']->getData(),
                                    'mail' => $form['mail']->getData(),
                                    'message' => $form['message']->getData()
                                ]
                            ),
                            // Define the mail's format
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
        // We create a cookie bandeau bound to the legacy notices's page, when the visitor go to this page, the cookie are accepted for 1 year
        setcookie('cookie-bandeauCookie', 'myseconddata', time() + 32140800, "/");

        return $this->render('general/mentionslegales.html.twig', [
            'last_path' => 'mentionslegales'
        ]);
    }
}