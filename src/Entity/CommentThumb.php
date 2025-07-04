<?php

namespace App\Entity;

use App\Repository\CommentThumbRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentThumbRepository::class)]
class CommentThumb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $type = null;

    #[ORM\ManyToOne(inversedBy: 'commentThumbs')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'commentThumbs')]
    private ?Comment $comment = null;

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

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
