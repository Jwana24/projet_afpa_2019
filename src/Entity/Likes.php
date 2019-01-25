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
    private $id_member_FK;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_article_FK;

    public function getId(): ?int
    {
        return $this->id;
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
}
