<?php

namespace App\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface UserInterface
{
    public function getId(): ?UuidInterface;

    public function setId(UuidInterface $id);

    public function getName(): ?string;

    public function setName(string $name);

    public function getEmail(): ?string;

    public function setEmail(string $email);

    public function toArray();

}
