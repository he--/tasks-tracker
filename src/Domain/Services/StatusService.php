<?php

namespace App\Domain\Services;

use App\Domain\Model\Status;
use App\Domain\Repository\StatusRepositoryInterface;

/**
 * Class StatusService
 * @package App\Domain\Services
 */
class StatusService
{

    /**
     * @var StatusRepositoryInterface
     */
    public StatusRepositoryInterface $statusRepository;

    /**
     * StatusService constructor.
     * @param StatusRepositoryInterface $statusRepository
     */
    public function __construct(StatusRepositoryInterface $statusRepository)
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
}
