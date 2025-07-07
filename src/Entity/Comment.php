<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    /**
     * @var Collection<int, CommentThumb>
     */
    #[ORM\OneToMany(targetEntity: CommentThumb::class, mappedBy: 'comment')]
    private Collection $commentThumbs;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'commentChildren')]
    #[ORM\JoinColumn(nullable: true)]
    private ?self $commentParent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'commentParent')]
    private Collection $commentChildren;

    public function __construct()
    {
        $this->commentThumbs = new ArrayCollection();
        $this->commentChildren = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    /**
     * @return Collection<int, CommentThumb>
     */
    public function getCommentThumbs(): Collection
    {
        return $this->commentThumbs;
    }

    public function addCommentThumb(CommentThumb $commentThumb): static
    {
        if (!$this->commentThumbs->contains($commentThumb)) {
            $this->commentThumbs->add($commentThumb);
            $commentThumb->setComment($this);
        }

        return $this;
    }

    public function removeCommentThumb(CommentThumb $commentThumb): static
    {
        if ($this->commentThumbs->removeElement($commentThumb)) {
            // set the owning side to null (unless already changed)
            if ($commentThumb->getComment() === $this) {
                $commentThumb->setComment(null);
            }
        }

        return $this;
    }

    public function getCommentParent(): ?self
    {
        return $this->commentParent;
    }

    public function setCommentParent(?self $commentParent): static
    {
        $this->commentParent = $commentParent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCommentChildren(): Collection
    {
        return $this->commentChildren;
    }

    public function addCommentChild(self $commentChild): static
    {
        if (!$this->commentChildren->contains($commentChild)) {
            $this->commentChildren->add($commentChild);
            $commentChild->setCommentParent($this);
        }

        return $this;
    }

    public function removeCommentChild(self $commentChild): static
    {
        if ($this->commentChildren->removeElement($commentChild)) {
            // set the owning side to null (unless already changed)
            if ($commentChild->getCommentParent() === $this) {
                $commentChild->setCommentParent(null);
            }
        }

        return $this;
    }
}
