<?php

namespace App\Domain\Model;

/**
 * class ProjetoRepositoryInterface
 * @package App\Domain\Model
 */
interface ProjetoRepositoryInterface
{
    public function salvar(Projeto $projeto): void;

    public function listar(): array;

    public function getNumeroProjetos(): int;
}
