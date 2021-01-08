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
class UsuarioRepositoryImpl extends ServiceEntityRepository implements UsuarioRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->findAll();
    }

    public function salvar(Usuario $usuario): void
    {
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
    }

}
