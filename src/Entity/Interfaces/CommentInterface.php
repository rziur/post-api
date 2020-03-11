<?php

namespace App\Entity\Interfaces;

use Ramsey\Uuid\UuidInterface;

interface CommentInterface
{
    public function getId(): ?UuidInterface;

    public function setId(UuidInterface $id);

    public function getMessage(): ?string;

    public function setMessage(string $message);

    public function getUser(): ?UserInterface;

    public function setUser(?UserInterface $user);

    public function getPost(): ?PostInterface;

    public function setPost(?PostInterface $post);

    public function toArray();
}
