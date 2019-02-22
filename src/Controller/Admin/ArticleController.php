<?php
// src/Controller/Admin/ArticleController.php
namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/article")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/add", name="add-article")
     */
    public function add(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $articleManager = $this->getDoctrine()->getManager();
            $article->setDateArticle(new \DateTime('NOW'));
            $article->setIdMemberFK($this->getUser());

            $image = $form['image']->getData();
            $folder = 'images/';
            $newName = strtr($image->getClientOriginalName(),
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $image->move($folder, $newName);
            $article->setImage($folder.$newName);
            
            $articleManager->persist($article);
            $articleManager->flush();
            $this->addFlash('success', 'Votre article a bien été ajouté');

            return $this->redirectToRoute('articles_list');
        }

        return $this->render('Admin/article/add.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'last_path' => 'add-article'
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Articles $article): Response
    {
        if($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token')))
        {
            $articleManager = $this->getDoctrine()->getManager();
            $articleManager->remove($article);
            $articleManager->flush();
            $this->addFlash('success', 'L\'article a été supprimé avec succès');
        }

        return $this->redirectToRoute('articles_list');
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Articles $article): Response
    {
        if($this->isCsrfTokenValid('edit-article'.$article->getId(), $request->request->get('_token')))
        {
            $image = $request->files->get('image');
            if($image)
            {
                $folder = 'images/';
                $newName = strtr($image->getClientOriginalName(),
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $image->move($folder, $newName);
                $article->setImage($folder.$newName);
            }
            else
            {
                $image = $article->getImage();
            }

            $articleManager = $this->getDoctrine()->getManager();
            $article->setTitleArticle($request->request->get('title_article'));
            $article->setTextArticle($request->request->get('text_article'));
            $articleManager->flush();

            return $this->json(['content' => [
                'title' => $article->getTitleArticle(),
                'text' => $article->getTextArticle(),
                'image' =>$article->getImage()
            ]]);
        }
        return $this->redirectToRoute('accueil');
    }
}