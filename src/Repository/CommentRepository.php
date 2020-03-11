<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Repository\Interfaces\CommentRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class CommentRepository extends AbstractEntityRepository implements CommentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }
}
