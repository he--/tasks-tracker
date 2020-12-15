<?php


namespace App\Domain\Model;

/**
 * class TaskRepositoryInterface
 * @package App\Domain\Model
 */
interface TaskRepositoryInterface
{
    public function salvar(Task $task): void;

    public function listar(): array;

    public function delete(Task $id): void;

   public function getNumeroTasks(): int;

   public function getStatus(): int;
}