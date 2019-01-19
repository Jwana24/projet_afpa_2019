<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Form\CommentType;
use App\Repository\ArticlesRepository;
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
    public function list(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articlesRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/show", name="show_article")
     */
    public function show(Articles $article, Request $request,  AuthorizationCheckerInterface $authChecker): Response
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
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'comments' => $article->getComments()
        ]);
    }
}