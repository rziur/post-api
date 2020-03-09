<?php

namespace App\Services\Interfaces;

use App\Entity\Interfaces\PostInterface;
use Ramsey\Uuid\UuidInterface;

interface PostServiceInterface
{
    public function create(?UuidInterface $id, string $title, string $body, UuidInterface $userId) : PostInterface;

    public function findPostsByUserId($userId);

    public function findPostWithComments($postId);

    public function  update($id, $title, $body);

    public function getPosts();
}
