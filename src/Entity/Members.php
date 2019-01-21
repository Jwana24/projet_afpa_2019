<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembersRepository")
 */
class Members implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\Email()
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255, options={"default":"avatars/default-avatar.jpg"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Posts", mappedBy="id_member_FK")
     */
    private $posts;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="date")
     */
    private $date_inscription;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Posts[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Posts $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setIdMemberFK($this);
        }

        return $this;
    }

    public function removePost(Posts $post): self
    {
        if ($this->posts->contains($post))
        {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getIdMemberFK() === $this)
            {
                $post->setIdMemberFK(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles = explode(',', $roles);

        if(empty($roles))
        {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = join(',', $roles);
    }

    public function getSalt(){}

    public function eraseCredentials(){}

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->mail,
            $this->password,
        ]);
    }

    public function unserialize($string)
    {
        list(
            $this->id,
            $this->username,
            $this->mail,
            $this->password,
        ) = unserialize($string, ['allowed_classes' => false]);
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
