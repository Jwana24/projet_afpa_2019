<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikesRepository")
 */
class Likes
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
    private $id_membre_FK;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_article_FK;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMembreFK(): ?members
    {
        return $this->id_membre_FK;
    }

    public function setIdMembreFK(?members $id_membre_FK): self
    {
        $this->id_membre_FK = $id_membre_FK;

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
}
