<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Projeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ProjetoRepositoryImpl
 * @package App\Infrastructure\Repository
 */
class ProjetoRepositoryImpl extends ServiceEntityRepository implements ProjetoRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projeto::class);
    }

    /**
     * @param Projeto $projeto
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function salvar(Projeto $projeto): void
    {
        $this->getEntityManager()->persist($projeto);
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
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getNumeroProjetos(): int
    {
        $queryBuilder = $this->createQueryBuilder("pro");
        $queryBuilder
            ->select($queryBuilder->expr()->count("pro"));

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
