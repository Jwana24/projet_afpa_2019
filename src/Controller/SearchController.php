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

        $paginationArt = $pageArticle;
        $paginationPo = $pagePost;

        // Make pagination only for articles (just 8 items on the page)
        if($paginationArt <= 1)
        {
            $paginationArt = 0;
        }
        else
        {
            $paginationArt = ($paginationArt - 1) * 8;
        }

        // Make pagination only for posts (just 8 items on the page)
        if($paginationPo <= 1)
        {
            $paginationPo = 0;
        }
        else
        {
            $paginationPo = ($paginationPo - 1) * 8;
        }

        return $this->render('general/search.html.twig', [
            'last_path' => 'search',
            'articles' => $articlesRepository->search($request->query->get('itemSearch'), $paginationArt),
            'posts' => $postsRepository->search($request->query->get('itemSearch'), $paginationPo),
            'numberPageArticle' => $pageArticle,
            'numberPagePost' => $pagePost,
            'postsPages' => ceil(count($postsRepository->searchCount($request->query->get('item-search'))) / 8),
            'articlesPages' => ceil(count($articlesRepository->searchCount($request->query->get('item-search'))) / 8),
            'resultSearch' => $request->query->get('itemSearch')
        ]);
    }
}