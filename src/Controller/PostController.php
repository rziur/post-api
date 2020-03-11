<?php

namespace App\Controller;

use App\Services\Interfaces\PostServiceInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route(path="/api/")
 */
class PostController extends AbstractController
{

    private $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @Route(
     *    "posts",
     *    name="create_post",
     *    methods={"POST"}
     * )
     */
    public function createPost(Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $postId = isset($body['postId']) ? $body['postId'] : null;
        $title = isset($body['title']) ? $body['title'] : null;
        $body_var = isset($body['body']) ? $body['body'] : null;
        $userId = isset($body['userId']) ? Uuid::fromString($body['userId']) : null;

        if (empty($title) || empty($body_var) || empty($userId)) {
            throw new \InvalidArgumentException('Expecting mandatory parameters!');
        }

        $post = $this->postService->create($postId, $title, $body_var, $userId);

        $data = $post->toArray();

        return new JsonResponse(
            $data,
            Response::HTTP_CREATED
        );

    }

    /**
     * @Route(
     *    "posts/user/{userId}",
     *    name="get_posts_by_user",
     *    methods={"GET"}
     * )
     */
    public function getPostsByUser($userId)
    {
        $id = isset($userId) ? Uuid::fromString($userId) : null;

        if (empty($id)) {
            throw new \InvalidArgumentException('Expecting mandatory parameters!');
        }

        $posts = $this->postService->findPostsByUserId($id);

        return $this->getPostResponse($posts);
    }

    /**
     * @Route(
     *    "posts/{id}/comments",
     *    name="get_posts_with_comments",
     *    methods={"GET"}
     * )
     */
    public function getPostDetailWithAllComments($id)
    {
        $postId = isset($id) ? Uuid::fromString($id) : null;

        if (empty($postId)) {
            throw new \InvalidArgumentException('Expecting mandatory parameters!');
        }

        $post = $this->postService->findPostWithComments($postId);

        $comments = $post->getComments();

        $dataComments = [];

        foreach ($comments as $comment) {
            $dataComments[] = $comment->toArray();
        }

        $data = [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'body' => $post->getBody(),
            'user' => $post->getUser()->toArray(),
            'comments' => $dataComments,
        ];

        return new JsonResponse(
            $data,
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route(
     *      "posts/{id}",
     *      name="update_post",
     *      methods={"PUT"})
     */
    public function updatePost($id, Request $request): JsonResponse
    {

        $body = json_decode($request->getContent(), true);

        $title = isset($body['title']) ? $body['title'] : null;
        $body_var = isset($body['body']) ? $body['body'] : null;

        $updatedPost = $this->postService->update($id, $title, $body_var);

        return new JsonResponse($updatedPost->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route(
     *      "posts",
     *      name="get_all_post",
     *      methods={"GET"}
     * )
     */
    public function getAllPost(): JsonResponse
    {
        $posts = $this->postService->getPosts();

        return $this->getPostResponse($posts);
    }

    private function getPostResponse($posts)
    {
        $data = [];

        foreach ($posts as $post) {
            $data[] = $post->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
