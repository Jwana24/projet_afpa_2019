<?php

namespace App\Controller;

use App\Entity\Members;
use App\Form\MemberType;
use App\Form\LostPasswordType;
use App\Repository\PostsRepository;
use App\Repository\MembersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/members")
 */
class MembersController extends Controller
{
    /**
     * @Route("/{id}", requirements={"id"="[0-9]{1,}"}, name="member_show", methods="GET")
     */
    public function show(Members $member): Response
    {
        return $this->render('members/show.html.twig', ['member' => $member]);
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
    public function delete(Request $request, Members $member, PostsRepository $manager): Response
    {
        $posts = $member->getPosts();
        $manager = $this->getDoctrine()->getManager();

        foreach($posts as $post)
        {
            $post->setIdMemberFK(NULL);
            $manager->flush();
        }

        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token')))
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($member);
            $manager->flush();
            

            
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