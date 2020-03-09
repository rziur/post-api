<?php

namespace App\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface PostInterface
{
    public function getId(): ?UuidInterface;

    public function setId(UuidInterface $id);

    public function getTitle(): ?string;

    public function setTitle(string $title);

    public function getBody(): ?string;

    public function setBody(?string $body);

    public function getUser(): ?UserInterface;

    public function setUser(?UserInterface $user);

    public function getComments(): Collection;

    public function addComment(CommentInterface $comment);

    public function removeComment(CommentInterface $comment);

    public function toArray();
}
