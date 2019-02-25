<?php
// src/Controller/PostController.php
namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostType;
use App\Entity\Responses;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/forum")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="posts_list", methods={"GET", "POST"})
     */
    public function list(Request $request, PostsRepository $postsRepository): Response
    {
        if($request->get('Catégories'))
        {
            $post = $postsRepository->findBy(['categorie'=>$request->get('Catégories')]);

            if(!$post)
            {
                $post = $postsRepository->findAll();
            }
        }
        else
        {
            $post = $postsRepository->findAll();
        }

        return $this->render('forum/index.html.twig', [
            'posts' => $post,
            'last_path' => 'posts_list'
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

        if($request->get('resolve'))
        {
            $post->setResolve('resolve');
            $postManager = $this->getDoctrine()->getManager();
            $postManager->flush();
        }

        return $this->render('forum/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'comments' => $post->getCommentsPosts(),
            'formResponse' => $formResponse->createView(),
            'last_path' => 'show_post:id='.$post->getId()
        ]);
    }

    /**
     * @Route("/new", name="add_post", methods={"POST", "GET"})
     * @Security("is_granted('ROLE_USER')")
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
            $this->addFlash('success', 'Le post a été bien été ajouté');

            return $this->redirectToRoute('posts_list');
        }

        return $this->render('forum/add.html.twig', [
            'posts' => $post,
            'form' => $form->createView(),
            'last_path' => 'add_post'
        ]);
    }

    /**
     * @Route("/{id}/editpost", name="post_edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function edit(Request $request, Posts $post): Response
    {
        // $form = $this->createForm(PostType::class, $post);
        // $form->handleRequest($request);

        // if($form->isSubmitted() && $form->isValid())
        // {
        //     $this->getDoctrine()->getManager()->flush();
        //     $this->addFlash('success', 'Le post a bien été modifié');

        //     return $this->redirectToRoute('show_post',[
        //         'id' => $post->getId()
        //     ]);
        // }

        // return $this->render('forum/edit.html.twig', [
        //     'post' => $post,
        //     'form' => $form->createView(),
        //     'last_path' => 'post_edit:id='.$post->getId()
        // ]);

        if($this->isCsrfTokenValid('edit-post'.$post->getId(), $request->request->get('_token')))
        {
            $postManager = $this->getDoctrine()->getManager();
            $post->setTitlePost($request->request->get('title_post'));
            $post->setTextPost($request->request->get('text_post'));
            $postManager->flush();

            return $this->json(['content' => [
                'title' => $post->getTitlePost(),
                'text' => $post->getTextPost()
            ]]);
        }
        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER')")
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