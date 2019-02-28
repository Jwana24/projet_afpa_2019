<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TranslationController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/translate/{_language}/{last_path}", name="translation", methods={"GET"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function edit($_language, $last_path) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setLocale($_language);
        $em->persist($user);
        $em->flush();

        $this->session->set('_locale', $_language); // we update the 'locale' key in the session and the element in the route (fr_FR or en)

        $path = explode(':', $last_path); // we cut the parameters on the route, we keep some of them, while the others change depending on the page who we are
        
        if(count($path) > 1) // we verify the existence of ':' to know if there is just a route or a route with parameters
        {
            $params = explode('=', $path[1]); // the '=' cut the names of the parameters and their values

            return $this->redirectToRoute($path[0], [$params[0] => $params[1]]); // we redirect depending on the route and the parameter(s) get it before
        }
        else
        {
            return $this->redirectToRoute($path[0]); // we redirect depending on the route without parameter(s)
        }
    }
}