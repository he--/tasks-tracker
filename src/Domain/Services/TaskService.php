<?php

namespace App\Domain\Services;

use App\Domain\Model\Projeto;
use App\Domain\Model\Task;
use App\Domain\Repository\TaskRepositoryInterface;

/**
 * Class TaskService
 * @package App\Domain\Services
 */
class TaskService
{

    /**
     * @var TaskRepositoryInterface
     */
    public TaskRepositoryInterface $taskRepository;

    /**
     * TaskService constructor.
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Task $task
     */
    public function salvar(Task $task)
    {
        $this->taskRepository->salvar($task);
    }

    /**
     * @return array
     */
    public function listar(): array
    {
        return $this->taskRepository->listar();
    }

    public function listarPorProjeto(Projeto $projeto): array
    {
        return $this->taskRepository->listarPorProjeto($projeto);
    }

    public function deletar(Task $task): void
    {
        $this->taskRepository->deletar($task);
    }
}
