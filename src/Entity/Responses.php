<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResponsesRepository")
 */
class Responses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_member_FK;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommentsPost", inversedBy="responses")
     */
    private $id_comment_post_FK;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comments", inversedBy="responses")
     */
    private $id_comment_FK;

    /**
     * @ORM\Column(type="text")
     */
    private $text_response;

    /**
     * @ORM\Column(type="date")
     */
    private $date_response;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMemberFK(): ?Members
    {
        return $this->id_member_FK;
    }

    public function setIdMemberFK(?Members $id_member_FK): self
    {
        $this->id_member_FK = $id_member_FK;

        return $this;
    }

    public function getIdCommentPostFK(): ?CommentsPost
    {
        return $this->id_comment_post_FK;
    }

    public function setIdCommentPostFK(?CommentsPost $id_comment_post_FK): self
    {
        $this->id_comment_post_FK = $id_comment_post_FK;

        return $this;
    }

    public function getIdCommentFK(): ?Comments
    {
        return $this->id_comment_FK;
    }

    public function setIdCommentFK(?Comments $id_comment_FK): self
    {
        $this->id_comment_FK = $id_comment_FK;

        return $this;
    }

    public function getTextResponse(): ?string
    {
        return $this->text_response;
    }

    public function setTextResponse(string $text_response): self
    {
        $this->text_response = $text_response;

        return $this;
    }

    public function getDateResponse(): ?\DateTimeInterface
    {
        return $this->date_response;
    }

    public function setDateResponse(\DateTimeInterface $date_response): self
    {
        $this->date_response = $date_response;

        return $this;
    }

    public function dateFormat()
    {
        $dateResponse = $this->date_response->format('D d M Y');
        
        $dateResponse = str_replace(
            [
                'Mon','Tue','Wed','Thu','Fri','Sat','Sun',
                'Feb', 'Apr', 'May', 'Jun', 'Jul', 'Aug'
            ],
            [
                'Lun','Mar','Mer','Jeu','Ven','Sam','Dim',
                'Fev', 'Avr', 'Mai', 'Jui', 'Jui', 'Aou'
            ],
        $dateResponse
        );
        
        return $dateResponse;
    }
}
