<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
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
    private $text_comment;

    /**
     * @ORM\Column(type="date")
     */
    private $date_comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_member_FK;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_article_FK;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Responses", mappedBy="id_comment_FK", cascade={"remove"})
     */
    private $responses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextComment(): ?string
    {
        return $this->text_comment;
    }

    public function setTextComment(string $text_comment): self
    {
        $this->text_comment = $text_comment;

        return $this;
    }

    public function getDateComment(): ?\DateTimeInterface
    {
        return $this->date_comment;
    }

    public function setDateComment(\DateTimeInterface $date_comment): self
    {
        $this->date_comment = $date_comment;

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

    public function getIdArticleFK(): ?articles
    {
        return $this->id_article_FK;
    }

    public function setIdArticleFK(?articles $id_article_FK): self
    {
        $this->id_article_FK = $id_article_FK;

        return $this;
    }

    /**
     * @return Collection|Responses[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Responses $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setIdCommentFK($this);
        }

        return $this;
    }

    public function removeResponse(Responses $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getIdCommentFK() === $this) {
                $response->setIdCommentFK(null);
            }
        }

        return $this;
    }
}
