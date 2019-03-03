<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recherche")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/{pageArticle}/{pagePost}", name="search", methods="POST|GET")
     */
    public function search(Request $request, ArticlesRepository $articlesRepository, PostsRepository $postsRepository, $pageArticle, $pagePost): Response
    {
        // We use our function (create in the repository) on the articles and posts
        $pageArticles = $pageArticle;
        $pagePosts = $pagePost;

        if($pagePosts <= 1)
        {
            $pagePosts = 0;
        }
        else
        {
            $pagePosts = ($pagePosts - 1) * 8;
        }

        if($pageArticles <= 1)
        {
            $pageArticles = 0;
        }
        else
        {
            $pageArticles = ($pageArticles - 1) * 8;
        }

        return $this->render('general/search.html.twig', [
            'last_path' => 'search',
            'articles' => $articlesRepository->search($request->query->get('s'), $pageArticles),
            'posts' => $postsRepository->search($request->query->get('s'), $pagePosts),
            'page_article' => $pageArticle,
            'page_post' => $pagePost,
            'number_page_post' => ceil(count($postsRepository->searchCount($request->query->get('s'))) / 8),
            'number_page_article' => ceil(count($articlesRepository->searchCount($request->query->get('s'))) / 8),
            'query' => $request->query->get('s')
        ]);
    }
}