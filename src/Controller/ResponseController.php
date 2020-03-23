<?php

namespace App\Controller;

use App\Entity\Responses;
use App\Form\ResponseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class ResponseController extends AbstractController
{
    /**
    * @Route("/{id}/editresponse", name="edit_response", methods={"GET", "POST"})
    */
    public function edit(Request $request, Responses $response): Response
    {
        if($this->isCsrfTokenValid('edit-response'.$response->getId(), $request->request->get('_token')))
        {
            $responseManager = $this->getDoctrine()->getManager();
            $response->setTextResponse($request->request->get('text_response'));
            $responseManager->flush();
            return $this->json(['content' => $response->getTextResponse()]);
        }
        return $this->redirectToRoute('accueil');
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
        if($this->isCsrfTokenValid('edit-response-post'.$responsePost->getId(), $request->request->get('_token')))
        {
            $responsePostManager = $this->getDoctrine()->getManager();
            $responsePost->setTextResponse($request->request->get('text_response_post'));
            $responsePostManager->flush();
            return $this->json(['content' => $responsePost->getTextResponse()]);
        }
        return $this->redirectToRoute('accueil');
    }

    /**
    * @Route("/{id}/responsespost", name="delete_response_post", methods={"DELETE"})
    */
    public function deletePost(Request $request, Responses $responsePost): Response
    {
        // If we delete a post, the responses bound to this post are deleted on cascade
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