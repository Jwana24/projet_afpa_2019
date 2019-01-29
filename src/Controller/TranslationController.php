<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/translate/{_language}/{last_path}", name="translation", methods={"GET"})
     */
    public function edit($_language, $last_path) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setLocale($_language);
        $em->persist($user);
        $em->flush();

        $this->session->set('_locale', $_language);

        $path = explode(':', $last_path);
        
        if(count($path) > 1)
        {
            $params = explode('=', $path[1]);

            return $this->redirectToRoute($path[0], [$params[0] => $params[1]]);
        }
        else
        {
            return $this->redirectToRoute($path[0]);
        }
    }
}