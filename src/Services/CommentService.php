<?php

namespace App\Services;

use App\Entity\Comment;
use App\Entity\Interfaces\CommentInterface;
use App\Exception\PostNotFoundException;
use App\Exception\UserNotFoundException;
use App\Repository\Interfaces\CommentRepositoryInterface;
use App\Repository\Interfaces\PostRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\CommentServiceInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CommentService implements CommentServiceInterface
{
    private $commentRepository;
    private $postRepository;
    private $userRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository,
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository,
        LoggerInterface $logger
    ) {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function create(?UuidInterface $id, string $message, UuidInterface $userId, UuidInterface $postId) : CommentInterface
    {
        $this->logger->debug('Request to create Comment');

        $user = $this->userRepository->repository()->findOneById($userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        
        $post = $this->postRepository->repository()->findOneById($postId);

        if ($post === null) {
            throw new PostNotFoundException();
        }

        $comment = Comment::create( $id ?? Uuid::uuid4(), $message);
        $comment->setUser($user);
        $comment->setPost($post);

        $this->commentRepository->persist($comment);

        $this->logger->debug('Created Information for Comment: "{post}"', ['post' => $post->getTitle()]);

        return $comment;
    }

    public function getComments()
    {
        return $this->commentRepository->repository()->findAll();
    }
}
