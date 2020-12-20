<?php

namespace App\Domain\Services;

use App\Domain\Model\Status;
use App\Domain\Model\Usuario;
use App\Infrastructure\Repository\StatusRepository;

/**
 * Class StatusService
 * @package App\Domain\Services
 */
class StatusService
{

    /**
     * @var StatusRepository
     */
    public StatusRepository $statusRepository;

    /**
     * StatusService constructor.
     * @param StatusRepository $statusoRepository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * @param Status $status
     */
    public function salvar(Status $status)
    {
        $this->statusRepository->salvar($status);
    }

    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->statusRepository->listar();
    }
    
    /**
     * @param Status $status
     */
    public function remover(Status $status)
    {
        $this->statusRepository->remover($status);
    }
}
