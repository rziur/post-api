<?php

namespace App\Services\Interfaces;

use App\Entity\Interfaces\UserInterface;
use Ramsey\Uuid\UuidInterface;

interface UserServiceInterface
{
    public function create(?UuidInterface $id, string $name, string $email) : UserInterface;

    public function getUsers();
}
