<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Projeto;
use App\Domain\Model\ProjetoRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ProjetoRepository
 * @package App\Infrastructure\Repository
 */
class ProjetoRepository extends ServiceEntityRepository implements ProjetoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projeto::class);
    }

    /**
     * @param Projeto $projeto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
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
    
    public function findByStatus($value)
    {
        return $this->createQueryBuilder('u')
        ->select('u')
         ->innerJoin('u.tasks', 't')
         ->innerJoin('t.status', 'i')
         ->Where('i.id = :status')
         ->setParameter('status', 2)
        ->andWhere('u.id = :id')
        ->setParameter('id', 32)
        ->getQuery()
        ->getSingleResult()
        ;
    }
}
