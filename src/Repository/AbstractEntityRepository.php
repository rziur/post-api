<?php

namespace App\Repository;

use App\Repository\Interfaces\EntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractEntityRepository extends ServiceEntityRepository implements EntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function entityManager()
    {
        return $this->_em;
    }

    public function persistList(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->_em->persist($entity);
        }
    }

    public function apply(): void
    {
        $this->_em->flush();
    }

    public function persist($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function remove($entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    public function persister(): callable
    {
        return function ($entity): void {
            $this->persist($entity);
        };
    }

    public function remover(): callable
    {
        return function ($entity): void {
            $this->remove($entity);
        };
    }

    public function repository(): EntityRepository
    {
        return $this->_em->getRepository($this->getClassName());
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->_em->createQueryBuilder();
    }

    public function paginate($dql, $page = 1, $limit = 10)
    {
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }
}
