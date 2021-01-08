<?php

namespace App\Domain\Repository;

use \App\Domain\Model\Projeto;

/**
 * Class ProjetoRepositoryInterface
 * @package App\Domain\Repository
 */
interface ProjetoRepositoryInterface
{
    public function salvar(Projeto $projeto): void;

    public function listar(): array;
}
