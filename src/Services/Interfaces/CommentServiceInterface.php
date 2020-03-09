<?php

namespace App\Services\Interfaces;

use App\Entity\Interfaces\CommentInterface;
use Ramsey\Uuid\UuidInterface;

interface CommentServiceInterface
{
    public function create(?UuidInterface $id, string $message, UuidInterface $userId, UuidInterface $postId) : CommentInterface;

    public function getComments();
}
