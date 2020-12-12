<?php

namespace App\Domain\Services;

use App\Domain\Model\Projeto;
use App\Domain\Model\ProjetoRepositoryInterface;

/**
 * Class ProjetoService
 * @package App\Domain\Services
 */
class ProjetoService
{

    /**
     * @var ProjetoRepositoryInterface
     */
    public ProjetoRepositoryInterface $projetoRepository;

    /**
     * ProjetoService constructor.
     * @param ProjetoRepositoryInterface $projetoRepository
     */
    public function __construct(ProjetoRepositoryInterface $projetoRepository)
    {
        $this->projetoRepository = $projetoRepository;
    }

    /**
     * @param Projeto $projeto
     */
    public function salvar(Projeto $projeto)
    {
        $this->projetoRepository->salvar($projeto);
    }

    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->projetoRepository->listar();
    }

    /**
     * @return array
     */
    public function getNumroDeProjetos(): int
    {
        return $this->projetoRepository->getNumeroProjetos();
    }
}
