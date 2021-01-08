<?php

namespace App\Domain\Service;

use App\Domain\Model\Projeto;

/**
 * class ProjetoService
 * @package App\Domain\Service
 */
interface ProjetoService
{
    public function salvar(Projeto $projeto): void;

    public function listar(): array;

    public function getNumeroProjetos(): int;
}