<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\UsuarioAtribuicao;
use App\Domain\Model\UsuarioAtribuicaoRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UsuarioAtribuicaoRepository
 * @package App\Infrastructure\Repository
 */
class UsuarioAtribuicaoRepository extends ServiceEntityRepository implements UsuarioAtribuicaoRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioAtribuicao::class);
    }

    /**
     * @return array
     */
    public function groupUserAtribuicao(): array
    {
        $queryBuilder = $this->createQueryBuilder("userAtrib");

        $queryBuilder
            ->select(
                [
                    'userAtrib.status',
                    $queryBuilder->expr()->count("userAtrib")
                ]
            )->groupBy('userAtrib.status')
        ;

        return $queryBuilder->getQuery()->execute();
    }
}
