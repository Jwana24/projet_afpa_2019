<?php
// src/Controller/PostController.php
namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostType;
use App\Entity\CommentsPost;
use App\Form\CommentPostType;
use App\Repository\PostsRepository;
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
    public function list(PostsRepository $postsRepository): Response
    {
        return $this->render('forum/index.html.twig', [
            'posts' => $postsRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/show", name="show_post")
     */
    public function show(Posts $post, Request $request, AuthorizationCheckerInterface $authChecker): Response
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

        return $this->render('forum/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'comments' => $post->getCommentsPosts()
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

        return $this->render('forum/add.html.twig', [
            'posts' => $post,
            'form' => $form->createView()
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