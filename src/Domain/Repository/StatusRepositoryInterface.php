<?php

namespace App\Domain\Repository;

use \App\Domain\Model\Status;

/**
 * Class StatusRepositoryInterface
 * @package App\Domain\Repository
 */
interface StatusRepositoryInterface
{
    public function salvar(Status $status): void;

    public function listar(): array;
}
