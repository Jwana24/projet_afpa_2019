<?php
// src/Controller/PostController.php
namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostType;
use App\Entity\Responses;
use App\Form\LanguageType;
use App\Form\ResponseType;
use App\Entity\CommentsPost;
use App\Form\CommentPostType;
use App\Repository\PostsRepository;
use App\Repository\CommentsPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/forum")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="posts_list", methods={"GET"})
     */
    public function list(Request $request, PostsRepository $postsRepository): Response
    {
        $form = $this->createForm(LanguageType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $locale = $form->getData()['locale'];
            $user = $this->getUser();
            $user->setLocale($locale);
            $em->persist($user);
            $em->flush();
        }

        return $this->render('forum/index.html.twig', [
            'posts' => $postsRepository->findAll(),
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/show", name="show_post")
     */
    public function show(CommentsPostRepository $commentPostRepository, Posts $post, Request $request, AuthorizationCheckerInterface $authChecker): Response
    {
        $comment = new CommentsPost();
        $form = $this->createForm(CommentPostType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $commentManager = $this->getDoctrine()->getManager();
            $comment->setDateCommentPost(new \DateTime('NOW'));
            $comment->setIdPostFK($post);
            $comment->setIdMemberFK($this->getUser());
            $commentManager->persist($comment);
            $commentManager->flush();
        }

        $response = new Responses();
        $formResponse = $this->createForm(ResponseType::class, $response);
        $formResponse->handleRequest($request);

        if($formResponse->isSubmitted() && $formResponse->isValid())
        {
            $responseManager = $this->getDoctrine()->getManager();
            $response->setDateResponse(new \DateTime('NOW'));
            $response->setIdCommentPostFK($commentPostRepository->find($request->get('id_comment')));
            $response->setIdMemberFK($this->getUser());
            $responseManager->persist($response);
            $responseManager->flush();
        }

        $formLanguage = $this->createForm(LanguageType::class);
        $formLanguage->handleRequest($request);

        if($formLanguage->isSubmitted() && $formLanguage->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $locale = $formLanguage->getData()['locale'];
            $user = $this->getUser();
            $user->setLocale($locale);
            $em->persist($user);
            $em->flush();
        }

        return $this->render('forum/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'comments' => $post->getCommentsPosts(),
            'formResponse' => $formResponse->createView(),
            'user' => $this->getUser(),
            'formLanguage' => $formLanguage->createView()
        ]);
    }

    /**
     * @Route("/new", name="add_post", methods={"POST", "GET"})
     */
    public function addPost(Request $request): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $postManager = $this->getDoctrine()->getManager();
            $post->setDatePost(new \DateTime('NOW'));
            $post->setIdMemberFK($this->getUser());
            $postManager->persist($post);
            $postManager->flush();

            return $this->redirectToRoute('posts_list');
        }

        $formLanguage = $this->createForm(LanguageType::class);
        $formLanguage->handleRequest($request);

        if($formLanguage->isSubmitted() && $formLanguage->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $locale = $formLanguage->getData()['locale'];
            $user = $this->getUser();
            $user->setLocale($locale);
            $em->persist($user);
            $em->flush();
        }

        return $this->render('forum/add.html.twig', [
            'posts' => $post,
            'form' => $form->createView(),
            'formLanguage' => $formLanguage->createView()
        ]);
    }

    /**
     * @Route("/{id}/editpost", name="post_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le post a été modifié avec succès');

            return $this->redirectToRoute('show_post',[
                'id' => $post->getId()
            ]);
        }

        return $this->render('forum/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posts $post): Response
    {
        if($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token')))
        {
            $postManager = $this->getDoctrine()->getManager();
            $postManager->remove($post);
            $postManager->flush();
            $this->addFlash('success', 'Le post a été supprimé avec succès');
        }

        return $this->redirectToRoute('posts_list');
    }
}