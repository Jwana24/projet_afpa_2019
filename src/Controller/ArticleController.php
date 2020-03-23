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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

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
        if($request->request->get('ajax-like'))
        {
            $like = new Likes();
            // Get a method in the LikesRepository to retrieve a member's likes regarding an article
            $countLike = $likeRepository->findByMember($this->getUser(), $article);

            if(count($countLike) == 0)
            {
                $likeManager = $this->getDoctrine()->getManager();
                $like->setIdArticleFK($article);
                $like->setIdMemberFK($this->getUser());
                $likeManager->persist($like);
                $likeManager->flush();
                
                return $this->json(['content' => true, 'nbLike' => count($article->getLikes())]);
            }
            else
            {
                $likeManager = $this->getDoctrine()->getManager();
                $likeManager->remove($countLike[0]);
                $likeManager->flush();
                return $this->json(['content' => false, 'nbLike' => count($article->getLikes())]);
            }
        }
        else
        {
            $countLike = $likeRepository->findByMember($this->getUser(), $article);
            $memberLike = false;

            if(count($countLike) == 0)
            {
                $memberLike = false;
            }
            else
            {
                $memberLike = true;
            }

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
                'likes' => count($article->getLikes()),
                'member_like' => $memberLike,
                'article' => $article,
                'form' => $form->createView(),
                'comments' => $article->getComments(),
                'formResponse' => $formResponse->createView(),
                'last_path' => 'show_article:id='.$article->getId()
            ]);
        }
    }
}