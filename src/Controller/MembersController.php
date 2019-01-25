<?php

namespace App\Controller;

use App\Entity\Members;
use App\Form\MemberType;
use App\Form\LanguageType;
use App\Form\LostPasswordType;
use App\Repository\PostsRepository;
use App\Repository\MembersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/members")
 */
class MembersController extends Controller implements EventSubscriberInterface
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function onLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if(!is_null($user->getLocale()))
        {
            $this->session->set('_locale', $user->getLocale());
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => [
                ['onLogin', 15]
            ]
        ];
    }

    /**
     * @Route("/{id}", requirements={"id"="[0-9]{1,}"}, name="member_show", methods="GET")
     */
    public function show(Request $request, Members $member): Response
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

        return $this->render('members/show.html.twig', [
            'member' => $member,
            'form' => $form->createView()
            ]);
    }

    /**
    * @Route("/inscription", name="inscription")
    */
    public function add(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $member = new Members();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $avatar = $form['avatar']->getData();
            
            if($avatar)
            {
                $folder = 'avatars/';
                $newName = strtr($avatar->getClientOriginalName(),
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $avatar->move($folder, $newName);
                $member->setAvatar($folder.$newName);
            }
            else
            {
                $member->setAvatar('avatars/default-avatar.jpg');
            }

            $memberManager = $this->getDoctrine()->getManager();
            $member->setDateInscription(new \DateTime('NOW'));
            $member->setRoles(['ROLE_USER']);
            $member->setPassword($encoder->encodePassword($member, $form['password']->getData()));
            $memberManager->persist($member);
            $memberManager->flush();
            $this->addFlash('success', 'Bienvenue ! :)');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('Members/inscription.html.twig', [
            'member' => $member,
            'form' => $form->createView()
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/{id}/edit", name="member_edit", methods="GET|POST")
     */
    public function edit(Request $request, Members $member, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $member->setPassword($encoder->encodePassword($member, $form['newPassword']->getData()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_edit', ['id' => $member->getId()]);
        }

        return $this->render('Members/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="member_delete", methods="DELETE")
     */
    public function delete(Request $request, Members $member, PostsRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token')))
        {
            $postRepository->setNullById($member->getId());
            $memberManager = $this->getDoctrine()->getManager();
            $memberManager->remove($member);
            $memberManager->flush();
        }

        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/motdepasseoublie", name="lostpassword", methods={"POST", "GET"})
     */
    public function lostPassword(Request $request, MembersRepository $membersRepository): Response
    {
        $form = $this->createForm(LostPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $member = $membersRepository->findByEmail($form['email']->getData());
            $token = $this->generateToken(50);

            if($member)
            {
                $member->setToken($token);
                $this->getDoctrine()->getManager()->flush();

                // $message = (new \Swift_Message('Demande de changement de mot de passe'))
                //     ->setFrom('contact@monsite.com')
                //     ->setTo($member->getMail())
                //     ->setBody(
                //         $this->renderView(
                //             'emails/lostpassword.html.twig',
                //             [
                //                 'username' => $member->getUsername(),
                //                 'token' => $token
                //             ]
                //         ),
                //         'text/html'
                //     );

                // $mailer->send($message);
                return $this->redirectToRoute('accueil');
            }
        }
        return $this->render('Members/lostpassword.html.twig', [
            'form' => $form->createView()
            ]);
    }

    public function generateToken($var)
    {
        $string = "";
        $chaine = "a0b1c2d3e4f5g6h7i8j9klmnpqrstuvwxy123456789";
        srand((double)microtime()*1000000);
        for($i=0; $i<$var; $i++)
        {
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }
}