<?php

namespace App\Domain\Repository;

use \App\Domain\Model\Task;

/**
 * Class TaskRepositoryInterface
 * @package App\Domain\Repository
 */
interface TaskRepositoryInterface
{
    public function salvar(Task $task): void;

    public function listar(): array;
}
