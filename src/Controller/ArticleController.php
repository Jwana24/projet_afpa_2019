<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use App\Entity\Likes;
use App\Form\LikeType;
use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Responses;
use App\Form\CommentType;
use App\Form\ResponseType;
use App\Repository\LikesRepository;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="articles_list")
     */
    public function list(Request $request, ArticlesRepository $articlesRepository): Response
    {

        return $this->render('article/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'last_path' => 'articles_list'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show_article")
     */
    public function show(CommentsRepository $commentRepository, LikesRepository $likeRepository, Articles $article, Request $request, AuthorizationCheckerInterface $authChecker): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $commentManager = $this->getDoctrine()->getManager();
            $comment->setDateComment(new \DateTime('NOW'));
            $comment->setIdArticleFK($article);
            $comment->setIdMemberFK($this->getUser());
            $commentManager->persist($comment);
            $commentManager->flush();
            
            return $this->redirectToRoute('show_article', ['id'=>$article->getId()]);
        }

        $like = new Likes();
        $formLike = $this->createForm(LikeType::class, $like);
        $formLike->handleRequest($request);
        $countLike = $likeRepository->findByMember($this->getUser(), $article);

        $memberLike = false;
        if(count($countLike) == 0)
        {
            $memberLike = false;

            if($formLike->isSubmitted() && $formLike->isValid())
            {
                $memberLike = true;
                $likeManager = $this->getDoctrine()->getManager();
                $like->setIdArticleFK($article);
                $like->setIdMemberFK($this->getUser());
                $likeManager->persist($like);
                $likeManager->flush();
            }
        }
        else
        {
            $memberLike = true;

            if($formLike->isSubmitted() && $formLike->isValid())
            {
                $memberLike = false;
                $likeManager = $this->getDoctrine()->getManager();
                $likeManager->remove($countLike[0]);
                $likeManager->flush();
            }
        }

        $response = new Responses();
        $formResponse = $this->createForm(ResponseType::class, $response);
        $formResponse->handleRequest($request);

        if($formResponse->isSubmitted() && $formResponse->isValid())
        {
            $responseManager = $this->getDoctrine()->getManager();
            $response->setDateResponse(new \DateTime('NOW'));
            $response->setIdCommentFK($commentRepository->find($request->get('id_comment')));
            $response->setIdMemberFK($this->getUser());
            $responseManager->persist($response);
            $responseManager->flush();

            return $this->redirectToRoute('show_article', ['id'=>$article->getId()]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'comments' => $article->getComments(),
            'likes' => count($article->getLikes()),
            'member_like' => $memberLike,
            'formLike' => $formLike->createView(),
            'formResponse' => $formResponse->createView(),
            'last_path' => 'show_article:id='.$article->getId()
        ]);
    }
}