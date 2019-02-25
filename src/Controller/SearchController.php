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
     * @Route("/", name="search", methods="POST|GET")
     */
    public function search(Request $request, ArticlesRepository $articlesRepository, PostsRepository $postsRepository): Response
    {

        return $this->render('general/search.html.twig', [
            'articles' => $articlesRepository->search($request->request->get('item-search')),
            'posts' => $postsRepository->search($request->request->get('item-search')),
            'last_path' => 'search'
        ]);
    }
}