<?php

namespace App\Application\Service;

use App\Domain\Model\Projeto;
use App\Domain\Service\ProjetoService;
use App\Infrastructure\Repository\ProjetoRepository;

/**
 * Class ProjetoServiceImpl
 * @package App\Application\Service
 */
class ProjetoServiceImpl implements ProjetoService
{

    /**
     * @var ProjetoRepository
     */
    public ProjetoRepository $projetoRepository;

    /**
     * ProjetoServiceImpl constructor.
     * @param ProjetoRepository $projetoRepository
     */
    public function __construct(ProjetoRepository $projetoRepository)
    {
        $this->projetoRepository = $projetoRepository;
    }

    /**
     * @param Projeto $projeto
     */
    public function salvar(Projeto $projeto): void
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
     * @return int
     */
    public function getNumeroProjetos(): int
    {
        return $this->projetoRepository->getNumeroProjetos();
    }
}
