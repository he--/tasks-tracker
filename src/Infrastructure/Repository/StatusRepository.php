<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Status;
use App\Domain\Repository\StatusRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class StatusRepository
 * @package App\Infrastructure\Repository
 */
class StatusRepository extends ServiceEntityRepository implements StatusRepositoryInterface
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
}
