<?php

namespace App\Services;

use App\Entity\Interfaces\PostInterface;
use App\Entity\Post;
use App\Exception\PostNotFoundException;
use App\Exception\UserNotFoundException;
use App\Repository\Interfaces\CommentRepositoryInterface;
use App\Repository\Interfaces\PostRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PostService implements PostServiceInterface
{
    private $postRepository;
    private $userRepository;
    private $commentRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository,
        CommentRepositoryInterface $commentRepository,
        LoggerInterface $logger
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->logger = $logger;
    }

    public function create(?UuidInterface $id, string $title, string $body, UuidInterface $userId) : PostInterface
    {
        $this->logger->debug('Request to create Post: "{title}"', ['title' => $title]);

        $user = $this->userRepository->repository()->findOneById($userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $post = Post::create( $id ?? Uuid::uuid4(), $title, $body);
        $post->setUser($user);

        $this->postRepository->persist($post);

        $this->logger->debug('Created Information for Post: "{post}"', ['post' => $post->getTitle()]);

        return $post;
    }

    public function findPostsByUserId($userId) 
    {
        return $this->postRepository->repository()->findBy(['user' => $userId]);
    }

    public function findPostWithComments($postId)
    {
        return $post = $this->postRepository->repository()->findOneBy(['id' => $postId]);
    }

    public function update($id, $title, $body)
    {
        $post = $this->postRepository->repository()->findOneBy(['id' => $id]);
        
        if ($post === null) {
            throw new PostNotFoundException();
        }

        empty($title) ? true : $post->setTitle($title);
        
        $post->setBody($body);

        $this->postRepository->persist($post);

        return $post;
    }

    public function getPosts()
    {
        return $this->postRepository->repository()->findAll();
    }
}
