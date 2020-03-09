<?php

namespace App\Controller;

use App\Services\Interfaces\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route(path="/api/")
 */
class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route(
     *    "users",
     *    name="create_user",
     *    methods={"POST"}
     * )
     */
    public function createUser(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $name = isset($data['name']) ? $data['name'] : null;
        $email = isset($data['email']) ? $data['email'] : null;
        $userId = isset($data['userId']) ? $data['userId'] : null;

        if (empty($name) || empty($email)) {
            throw new \InvalidArgumentException('Expecting mandatory parameters!');
        }

        $user = $this->userService->create($userId, $name, $email);

        $data = $user->toArray();

        return new JsonResponse(
            $data,
            Response::HTTP_CREATED
        );

    }

    /**
     * @Route(
     *      "users",
     *      name="get_all_users",
     *      methods={"GET"}
     * )
     */
    public function getAllUsers(): JsonResponse
    {
        $users = $this->userService->getUsers();
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
