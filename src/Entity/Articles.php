<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */
class Articles
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
    private $title_article;

    /**
     * @ORM\Column(type="text")
     */
    private $text_article;

    /**
     * @ORM\Column(type="date")
     */
    private $date_article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_member_FK;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Likes", mappedBy="id_article_FK", orphanRemoval=true, cascade={"remove"})
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="id_article_FK", orphanRemoval=true, cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    private $session;
    
    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleArticle(): ?string
    {
        return $this->title_article;
    }

    public function setTitleArticle(string $title_article): self
    {
        $this->title_article = $title_article;

        return $this;
    }

    public function getTextArticle(): ?string
    {
        return $this->text_article;
    }

    public function setTextArticle(string $text_article): self
    {
        $this->text_article = $text_article;

        return $this;
    }

    public function getDateArticle(): ?\DateTimeInterface
    {
        return $this->date_article;
    }

    public function setDateArticle(\DateTimeInterface $date_article): self
    {
        $this->date_article = $date_article;

        return $this;
    }

    // function to tranform the date format (ex : 'Tue 10 May 2019')
    
    public function dateFormat()
    {
        $dateArticle = $this->date_article->format('D d M Y');
        
        $dateArticle = str_replace(
            [
                'Mon','Tue','Wed','Thu','Fri','Sat','Sun',
                'Feb', 'Apr', 'May', 'Jun', 'Jul', 'Aug'
            ],
            [
                'Lun','Mar','Mer','Jeu','Ven','Sam','Dim',
                'Fev', 'Avr', 'Mai', 'Jui', 'Jui', 'Aou'
            ],
        $dateArticle
        );
        
        return $dateArticle;
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
     * @return Collection|Likes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setIdArticleFK($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getIdArticleFK() === $this) {
                $like->setIdArticleFK(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setIdArticleFK($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getIdArticleFK() === $this) {
                $comment->setIdArticleFK(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
