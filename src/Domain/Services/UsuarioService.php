<?php


namespace App\Domain\Services;


use App\Domain\Model\Usuario;
use App\Domain\Model\UsuarioRepositoryInterface;


/**
 * Class ProjetoService
 * @package App\Domain\Services
 */
class UsuarioService
{
    /**
     * @var UsuarioRepositoryInterface
     */
    public UsuarioRepositoryInterface $usuarioRepository;

    /**
     * ProjetoService constructor.
     * @param UsuarioRepositoryInterface $usuarioRepository
     */
    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
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
     * @param Usuario $id
     */
    public function delete(Usuario $id)
    {
        $this->usuarioRepository->delete($id);
    }

    /**
     * @param Usuario $id
     */
    public function editar(Usuario $id)
    {
        $this->usuarioRepository->editar($id);
    }

    /**
     * @param array
     */
    public function listar()
    {
        $this->usuarioRepository->listar();
    }
}