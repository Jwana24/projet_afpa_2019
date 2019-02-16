<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class CommentController extends AbstractController
{
    /**
    * @Route("/{id}/edit", name="edit_comment", methods={"GET", "POST"})
    */
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le commentaire a été modifié avec succès');
            
            return $this->redirectToRoute('show_article',[
                'id' => $comment->getIdArticleFK()->getId()
            ]);
        }

        return $this->render('article/comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
            'last_path' => 'edit_comment:id='.$comment->getId()
        ]);
    }


    /**
    * @Route("/{id}", name="delete_comment", methods={"DELETE"})
    */
    public function delete(Request $request, Comments $comment): Response
    {
        if($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token')))
        {
            $commentManager = $this->getDoctrine()->getManager();
            $commentManager->remove($comment);
            $commentManager->flush();
            $this->addFlash('success', 'Le commentaire a été supprimé avec succès');
        }

        return $this->redirectToRoute('show_article',[
            'id' => $comment->getIdArticleFK()->getId()
        ]);
    }
}