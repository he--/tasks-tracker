<?php


namespace App\Domain\Model;


interface UsuarioRepositoryInterface
{
    public function salvar(Usuario $usuario): void;
    public function delete(Usuario $id): void;
    public function editar(Usuario $id): void;
    public function listar(): array;
}