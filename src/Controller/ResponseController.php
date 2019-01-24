<?php

namespace App\Controller;

use App\Entity\Responses;
use App\Form\ResponseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResponseController extends AbstractController
{
    /**
    * @Route("/{id}/editresponse", name="edit_response", methods={"GET", "POST"})
    */
    public function edit(Request $request, Responses $response): Response
    {
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La réponse a été modifiée avec succès');
            
            return $this->redirectToRoute('show_article',[
                'id' => $response->getIdCommentFK()->getIdArticleFK()->getId()
            ]);
        }

        return $this->render('article/responses/edit.html.twig', [
            'response' => $response,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/{id}/responses", name="delete_response", methods={"DELETE"})
    */
    public function delete(Request $request, Responses $response): Response
    {
        if($this->isCsrfTokenValid('delete'.$response->getId(), $request->request->get('_token')))
        {
            $responseManager = $this->getDoctrine()->getManager();
            $responseManager->remove($response);
            $responseManager->flush();
            $this->addFlash('success', 'La réponse a été supprimée avec succès');
        }

        return $this->redirectToRoute('show_article',[
            'id' => $response->getIdCommentFK()->getIdArticleFK()->getId()
        ]);
    }

    /**
    * @Route("/{id}/editresponsepost", name="edit_response_post", methods={"GET", "POST"})
    */
    public function editPost(Request $request, Responses $responsePost): Response
    {
        $formPost = $this->createForm(ResponseType::class, $responsePost);
        $formPost->handleRequest($request);

        if($formPost->isSubmitted() && $formPost->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La réponse a été modifiée avec succès');
            
            return $this->redirectToRoute('show_post',[
                'id' => $responsePost->getIdCommentPostFK()->getIdPostFK()->getId()
            ]);
        }

        return $this->render('forum/responsesPost/edit.html.twig', [
            'response' => $responsePost,
            'formPost' => $formPost->createView()
        ]);
    }

    /**
    * @Route("/{id}/responsespost", name="delete_response_post", methods={"DELETE"})
    */
    public function deletePost(Request $request, Responses $responsePost): Response
    {
        if($this->isCsrfTokenValid('delete'.$responsePost->getId(), $request->request->get('_token')))
        {
            $responsePostManager = $this->getDoctrine()->getManager();
            $responsePostManager->remove($responsePost);
            $responsePostManager->flush();
            $this->addFlash('success', 'La réponse a été supprimée avec succès');
        }

        return $this->redirectToRoute('show_post',[
            'id' => $responsePost->getIdCommentPostFK()->getIdPostFK()->getId()
        ]);
    }
}