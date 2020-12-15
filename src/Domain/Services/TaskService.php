<?php


namespace App\Domain\Services;
use App\Domain\Model\Task;
use App\Domain\Model\TaskRepositoryInterface;

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

    /**
     * @param Task $id
     */
    public function delete(Task $id)
    {
        $this->taskRepository->delete($id);
    }

    /**
     * @return array
     */
    public function getNumeroTasks(): int
    {
        return $this->taskRepository->getNumeroTasks();
    }

    /**
     * @return array
     */
    public function getStatus(): int
    {
        return $this->taskRepository->getStatus();
    }



}