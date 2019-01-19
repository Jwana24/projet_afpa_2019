<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsPostRepository")
 */
class CommentsPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text_comment_post;

    /**
     * @ORM\Column(type="date")
     */
    private $date_comment_post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_member_FK;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\posts", inversedBy="commentsPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_post_FK;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextCommentPost(): ?string
    {
        return $this->text_comment_post;
    }

    public function setTextCommentPost(string $text_comment_post): self
    {
        $this->text_comment_post = $text_comment_post;

        return $this;
    }

    public function getDateCommentPost(): ?\DateTimeInterface
    {
        return $this->date_comment_post;
    }

    public function setDateCommentPost(\DateTimeInterface $date_comment_post): self
    {
        $this->date_comment_post = $date_comment_post;

        return $this;
    }

    public function getIdMemberFK(): ?members
    {
        return $this->id_member_FK;
    }

    public function setIdMemberFK(?members $id_member_FK): self
    {
        $this->id_member_FK = $id_member_FK;

        return $this;
    }

    public function getIdPostFK(): ?posts
    {
        return $this->id_post_FK;
    }

    public function setIdPostFK(?posts $id_post_FK): self
    {
        $this->id_post_FK = $id_post_FK;

        return $this;
    }
}
