<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Projeto;
use App\Domain\Model\Task;
use App\Domain\Repository\TaskRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TaskRepository
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

    public function listarPorProjeto(Projeto $projeto)
    {
        return $this->createQueryBuilder('t')
                ->andWhere('t.projeto = :projeto')
                ->setParameter('projeto', $projeto->getId())
                ->orderBy('t.id', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function deletar(Task $task): void
    {
        $this->getEntityManager()->remove($task);
        $this->getEntityManager()->flush();
    }
}
