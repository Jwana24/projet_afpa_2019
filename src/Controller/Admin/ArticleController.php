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
        // Create a new form according to the fields in the Type (this type is create before with a command 'php bin/console make:form')
        $form = $this->createForm(ArticleType::class, $article);
        // It's the moment where the form with parameters are captured
        $form->handleRequest($request);

        // Verify the fields in the form are conform to the rules create in the entities
        if($form->isSubmitted() && $form->isValid())
        {
            // We bound our object to the functions pre-create by Doctrine, that manage the entities
            $articleManager = $this->getDoctrine()->getManager();
            // We update the informations whose we need in the entity
            $article->setDateArticle(new \DateTime('NOW'));
            $article->setIdMemberFK($this->getUser());

            // Get the file uploded
            $image = $form['image']->getData();
            // Defines the folder where the file will be placed
            $folder = 'images/';
            // Construct the new name of the image without accents
            $newName = strtr($image->getClientOriginalName(),
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            // We move the image in our new folder and we change is name with the previous construction
            $image->move($folder, $newName);
            // We update the image in the entity
            $article->setImage($folder.$newName);
            
            // We save the entity in the ArticleManager and we push the modifications in the database
            $articleManager->persist($article);
            $articleManager->flush();
            $this->addFlash('success', 'Votre article a bien été ajouté');

            // Redirect on the articles list
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
        // We verify if the admin do the action for delete the article and if the token in the twig is the same to the token in the session
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
        // The edit executed on the same page than the show page, the form is not create with the Symfony's FormBuilder
        if($this->isCsrfTokenValid('edit-article'.$article->getId(), $request->request->get('_token')))
        {
            // Get the file uploded in the request
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

            $articleManager = $this->getDoctrine()->getManager();
            $article->setTitleArticle($request->request->get('title_article'));
            $article->setTextArticle($request->request->get('text_article'));
            $articleManager->flush();

            // Return an Json object with article's data
            return $this->json(['content' => [
                'title' => $article->getTitleArticle(),
                'text' => $article->getTextArticle(),
                'image' =>$article->getImage()
            ]]);
        }
        return $this->redirectToRoute('accueil');
    }
}