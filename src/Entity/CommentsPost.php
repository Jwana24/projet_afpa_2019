<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Responses", mappedBy="id_comment_post_FK", cascade={"remove"})
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

    public function dateFormat()
    {
        $dateCommentPost = $this->date_comment_post->format('D d M Y');
        
        $dateCommentPost = str_replace(
            [
                'Mon','Tue','Wed','Thu','Fri','Sat','Sun',
                'Feb', 'Apr', 'May', 'Jun', 'Jul', 'Aug'
            ],
            [
                'Lun','Mar','Mer','Jeu','Ven','Sam','Dim',
                'Fev', 'Avr', 'Mai', 'Jui', 'Jui', 'Aou'
            ],
        $dateCommentPost
        );
        
        return $dateCommentPost;
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
            $response->setIdCommentPostFK($this);
        }

        return $this;
    }

    public function removeResponse(Responses $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getIdCommentPostFK() === $this) {
                $response->setIdCommentPostFK(null);
            }
        }

        return $this;
    }
}
