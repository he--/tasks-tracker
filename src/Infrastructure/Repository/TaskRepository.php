<?php

namespace App\Infrastructure\Repository;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use App\Domain\Model\TaskRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ProjetoRepository
 * @package App\Infrastructure\Repository
 */
class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param Task $task
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function salvar(Task $task): void
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->findAll();
    }

    /**
     * @param Task $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Task $id): void
    {
        $this->getEntityManager()->remove($id);
        $this->getEntityManager()->flush();
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNumeroTasks(): int
    {

        $queryBuilder = $this->createQueryBuilder("pro");
        $queryBuilder
            ->select($queryBuilder->expr()->count("pro"));

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getStatus(): int
    {

        $queryBuilder = $this->createQueryBuilder("task");
        $queryBuilder
            ->select($queryBuilder->expr()->count("task.status"))->where("task.status = 4");

        return $queryBuilder->getQuery()->getSingleScalarResult();


    }
}
