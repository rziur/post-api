<?php

namespace App\Repository\Interfaces;


interface EntityRepositoryInterface
{
    public function entityManager();

    public function apply(): void;

    public function persist($entity): void;

    public function persistList(array $entities): void;

    public function remove($entity): void;

    public function persister(): callable;

    public function remover(): callable;

    public function repository();

    public function queryBuilder();

    public function paginate($dql, $page = 1, $limit = 3);
}
