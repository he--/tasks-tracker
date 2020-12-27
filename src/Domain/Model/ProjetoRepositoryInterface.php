<?php

namespace App\Domain\Model;

/**
 * Class ProjetoRepositoryInterface
 * @package App\Domain\Model
 */
interface ProjetoRepositoryInterface
{
    public function salvar(Projeto $projeto): void;

    public function listar(): array;
    
    public function findByStatus($value);
}
