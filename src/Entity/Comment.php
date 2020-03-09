<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Interfaces\CommentInterface;
use App\Entity\Interfaces\PostInterface;
use App\Entity\Interfaces\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\PostInc;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment implements CommentInterface
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * 
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=750)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    public static function create(UuidInterface $id,string $message): Comment {

        $self = new self();
        $self->id = $id;
        $self->message = $message;

        return $self;
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?PostInterface
    {
        return $this->post;
    }

    public function setPost(?PostInterface $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function toArray()
    {
        return  [
            'id' => $this->id,
            'message' => $this->message,
            'user' => $this->user->toArray()
        ];
    }

}
