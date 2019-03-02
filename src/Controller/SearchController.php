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
     * @Route("/{page}/{page2}", name="search", methods="POST|GET")
     */
    public function search(Request $request, ArticlesRepository $articlesRepository, PostsRepository $postsRepository, $page, $page2): Response
    {
        // We use our function (create in the repository) on the articles and posts

        return $this->render('general/search.html.twig', [
            'last_path' => 'search',
            'nb_page' => count($searchResults) / 8,
            'articles' => $articlesRepository->search($request->request->get('item-search')),
            'posts' => $postsRepository->search($request->request->get('item-search')),
            'nombre-page-article' => $page,
            'nombre-page-post' => $page2,
            'number-page-post' => count($postsRepository->searchCount($request->request->get('item-search'))) / 8,
            'number-page-article' => count($articlesRepository->search($request->request->get('item-search'))) / 8
        ]);
    }
}