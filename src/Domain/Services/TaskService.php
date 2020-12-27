<?php

namespace App\Domain\Services;

use App\Domain\Model\Status;
use App\Domain\Model\Usuario;
use App\Infrastructure\Repository\StatusRepository;
use App\Infrastructure\Repository\TaskRepository;
use App\Domain\Model\Task;

/**
 * Class TaskService
 * @package App\Domain\Services
 */
class TaskService
{

    /**
     * @var TaskRepository
     */
    public TaskRepository $taskRepository;

    /**
     * TaskService constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Task $status
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
    
    /**
     * @param Task $task
     */
    public function remover(Status $task)
    {
        $this->taskRepository->remover($task);
    }
}
