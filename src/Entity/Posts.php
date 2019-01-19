<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostsRepository")
 */
class Posts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title_post;

    /**
     * @ORM\Column(type="text")
     */
    private $text_post;

    /**
     * @ORM\Column(type="date")
     */
    private $date_post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Members", inversedBy="posts")
     */
    private $id_member_FK;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentsPost", mappedBy="id_post_FK", orphanRemoval=true)
     */
    private $commentsPosts;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $categorie;

    public function __construct()
    {
        $this->commentsPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitlePost(): ?string
    {
        return $this->title_post;
    }

    public function setTitlePost(string $title_post): self
    {
        $this->title_post = $title_post;

        return $this;
    }

    public function getTextPost(): ?string
    {
        return $this->text_post;
    }

    public function setTextPost(string $text_post): self
    {
        $this->text_post = $text_post;

        return $this;
    }

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->date_post;
    }

    public function setDatePost(\DateTimeInterface $date_post): self
    {
        $this->date_post = $date_post;

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

    /**
     * @return Collection|CommentsPost[]
     */
    public function getCommentsPosts(): Collection
    {
        return $this->commentsPosts;
    }

    public function addCommentsPost(CommentsPost $commentsPost): self
    {
        if (!$this->commentsPosts->contains($commentsPost)) {
            $this->commentsPosts[] = $commentsPost;
            $commentsPost->setIdPostFK($this);
        }

        return $this;
    }

    public function removeCommentsPost(CommentsPost $commentsPost): self
    {
        if ($this->commentsPosts->contains($commentsPost)) {
            $this->commentsPosts->removeElement($commentsPost);
            // set the owning side to null (unless already changed)
            if ($commentsPost->getIdPostFK() === $this) {
                $commentsPost->setIdPostFK(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
