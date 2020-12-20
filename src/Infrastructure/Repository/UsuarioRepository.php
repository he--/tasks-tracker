<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    // /**
    //  * @return Usuario[] Returns an array of Usuario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usuario
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    /**
     * @param Usuario $projeto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function salvar(Usuario $usuario): void
    {
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
    }
    
    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->findAll();
    }
    
    public function remover(Usuario $usuario): void
    {
        $this->getEntityManager()->remove($usuario);
        $this->getEntityManager()->flush();
    }
}
