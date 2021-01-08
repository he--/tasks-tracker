<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Usuario;

/**
 * class UsuarioRepository
 * @package App\Infrastructure\Repository
 */
interface UsuarioRepository
{
    public function salvar(Usuario $usuario): void;

    public function listar(): array;
}
