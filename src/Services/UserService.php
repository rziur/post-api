<?php

namespace App\Services;

use App\Entity\Interfaces\UserInterface;
use App\Entity\User;
use App\Exception\EmailAlreadyUsedException;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository,LoggerInterface $logger) {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function create(?UuidInterface $id, string $name, string $email) : UserInterface
    {
        $this->logger->debug('Request to create User: "{user}"', ['user' => $name]);

        if ($this->userRepository->findOneByEmail(strtolower($email)) != null) {
            throw new EmailAlreadyUsedException();
        }

        $user = User::create( $id ?? Uuid::uuid4(), $name, $email);

        $this->userRepository->persist($user);

        $this->logger->debug('Created Information for User: "{user}"', ['user' => $user->getName()]);

        return $user;
    }

    public function getUsers()
    {
        return $this->userRepository->repository()->findAll();
    }
}
