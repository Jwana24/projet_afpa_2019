<?php

namespace App\Controller;

use App\Entity\CommentsPost;
use App\Form\CommentPostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class CommentPostController extends AbstractController
{
    /**
    * @Route("/{id}/editpost", name="edit_comment_post", methods={"GET", "POST"})
    */
    public function edit(Request $request, CommentsPost $comment): Response
    {
        $form = $this->createForm(CommentPostType::class, $comment);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le commentaire a été modifié avec succès');
            
            return $this->redirectToRoute('show_post',[
                'id' => $comment->getIdPostFK()->getId()
            ]);
        }

        return $this->render('forum/commentsPost/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
            'last_path' => 'edit_comment_post:id='.$comment->getId()
        ]);
    }


    /**
    * @Route("/{id}/commentPost", name="delete_comment_post", methods={"DELETE"})
    */
    public function delete(Request $request, CommentsPost $comment): Response
    {
        if($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token')))
        {
            $commentManager = $this->getDoctrine()->getManager();
            $commentManager->remove($comment);
            $commentManager->flush();
            $this->addFlash('success', 'Le commentaire a été supprimé avec succès');
        }

        return $this->redirectToRoute('show_post',[
            'id' => $comment->getIdPostFK()->getId()
        ]);
    }
}