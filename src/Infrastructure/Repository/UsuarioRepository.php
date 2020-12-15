<?php

namespace App\Infrastructure\Repository;

use App\Domain\Form\Type\UsuarioType;
use App\Domain\Model\Usuario;
use App\Domain\Model\UsuarioRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository implements UsuarioRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }


    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNumeroUsers(): int
    {
        $queryBuilder = $this->createQueryBuilder("user");
        $queryBuilder
            ->select($queryBuilder->expr()->count("user"));

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param Usuario $usuario
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function salvar(Usuario $usuario): void
    {
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Usuario $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Usuario $id): void
    {
        $this->getEntityManager()->remove($id);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Usuario $usuario
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editar(Usuario $usuario): void
    {
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
    }

    /**
     * @param array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function listar(): array
    {
        return $this
            ->getEntityManager()
            ->getRepository(Usuario::class)
            ->findAll();
    }
}
