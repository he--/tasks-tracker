<?php

namespace App\Domain\Services;

use App\Domain\Model\Projeto;
use App\Domain\Model\ProjetoRepositoryInterface;
use App\Infrastructure\Repository\UsuarioRepository;
use App\Domain\Model\Usuario;

/**
 * Class ProjetoService
 * @package App\Domain\Services
 */
class UsuarioService
{

    /**
     * @var UsuarioRepository
     */
    public UsuarioRepository $usuarioRepository;

    /**
     * UsuarioService constructor.
     * @param UsuarioRepository $usuarioRepository
     */
    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @param Usuario $usuario
     */
    public function salvar(Usuario $usuario)
    {
        $this->usuarioRepository->salvar($usuario);
    }

    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->usuarioRepository->listar();
    }
    
    /**
     * @param Usuario $usuario
     */
    public function remover(Usuario $usuario)
    {
        $this->usuarioRepository->remover($usuario);
    }
}
