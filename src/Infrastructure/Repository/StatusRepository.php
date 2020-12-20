<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class StatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }
    
    /**
     * @param Status $status
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function salvar(Status $status): void
    {
        $this->getEntityManager()->persist($status);
        $this->getEntityManager()->flush();
    }
    
    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->findAll();
    }
    
    public function remover(Status $status): void
    {
        $this->getEntityManager()->remove($status);
        $this->getEntityManager()->flush();
    }
}
