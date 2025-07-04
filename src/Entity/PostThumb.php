<?php

namespace App\Entity;

use App\Repository\PostThumbRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostThumbRepository::class)]
class PostThumb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $type = null;

    #[ORM\ManyToOne(inversedBy: 'postThumbs')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'postThumbs')]
    private ?Post $post = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }
}
