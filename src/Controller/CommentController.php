<?php

namespace App\Controller;

use App\Services\Interfaces\CommentServiceInterface;
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
class CommentController extends AbstractController
{
    private $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @Route(
     *    "comments",
     *    name="create_comment",
     *    methods={"POST"}
     * )
     */
    public function createComment(Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $commentId = isset($body['commentId']) ? $body['commentId'] : null; 
        $message = isset($body['message']) ? $body['message'] : null;
        $userId = isset($body['userId']) ? Uuid::fromString( $body['userId'] ) : null;
        $postId = isset($body['postId']) ? Uuid::fromString($body['postId']) : null;

        if (empty($message) || empty($userId) || empty($postId)) {
            throw new \InvalidArgumentException('Expecting mandatory parameters!');
        }

        $comment = $this->commentService->create($commentId, $message, $userId, $postId);

        $data = $comment->toArray();

        return new JsonResponse(
            $data,
            Response::HTTP_CREATED
        );

    }

    /**
     * @Route(
     *      "comments",
     *      name="get_all_comment",
     *      methods={"GET"}
     * )
     */
    public function getAllComments(): JsonResponse
    {
        $comments = $this->commentService->getComments();
        $data = [];

        foreach ($comments as $comment) {
            $data[] = $comment->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
