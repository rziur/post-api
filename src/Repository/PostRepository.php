<?php

namespace App\Repository;

use App\Entity\Post;
use App\Repository\Interfaces\PostRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class PostRepository extends AbstractEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

}
