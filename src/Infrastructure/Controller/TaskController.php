<?php

namespace App\Infrastructure\Controller;

use App\Domain\Form\Type\TaskType;
use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use App\Domain\Model\UsuarioAtribuicao;
use \App\Domain\Services\TaskService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tasks")
 */
class TaskController extends AbstractController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @Route("/listar", name="task_listar")
     */
    public function listarTasks()
    {
        $tasks = $this->taskService->listar();

        return $this->render('lista-tasks.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/projeto/{projeto}", name="task_projeto_listar")
     * @ParamConverter("projeto", class="App\Domain\Model\Projeto")
     * @param Projeto $projeto
     */
    public function listarTasksPorProjeto(Projeto $projeto)
    {
        $tasks = $this->taskService->listarPorProjeto($projeto);

        return $this->render('lista-tasks.html.twig', [
            'tasks' => $tasks,
            'projeto' => $projeto
        ]);
    }

    /**
     * @Route("/atribuir/{task}" , name="atribuir_task")
     * @ParamConverter("task", class="App\Domain\Model\Task")
     */
    public function atribuir(Task $task)
    {
        $user = $this->getUser();

        $usuarioTask = new UsuarioAtribuicao();
        $status = $this->getDoctrine()->getRepository(Status::class)->find(2);
        $usuarioTask->setStatus($status);
        $usuarioTask->setUsuario($user);
        $usuarioTask->setDtAtribuicao(new \DateTime());
        $usuarioTask->setTask($task);

        $task->setStatus($status);

        $this->getDoctrine()->getManager()->persist($status);
        $this->getDoctrine()->getManager()->persist($usuarioTask);

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Task alocada com sucesso!!!');

        return $this->redirectToRoute('listar_projetos');

    }

    /**
     * @Route("/cadastrar/{projeto}", name="task_cadastrar", methods={"GET", "POST"})
     * @ParamConverter("projeto", class="App\Domain\Model\Projeto")
     * @param Projeto $projeto
     */
    public function cadastrar(Projeto $projeto, Request $request)
    {
        $form = $this->createForm(TaskType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $task =  $form->getData();
            $task->setProjeto($projeto);
            $this->taskService->salvar($task);

            $this->addFlash('success','Task Cadastrada com sucesso');

            return $this->redirect('/tasks/projeto/'.$projeto->getId());
        }

        return $this->render('novo-task.html.twig', [
            'form' => $form->createView(),
            'projeto' => $projeto
        ]);
    }

    /**
     * @Route("/editar/{task}", name="task_editar", methods={"GET", "POST"})
     * @ParamConverter("task", class="App\Domain\Model\Task")
     */
    public function editar(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $task =  $form->getData();
            $this->taskService->salvar($task);

            $this->addFlash('success','Task alterada com sucesso');

            return $this->redirect('/tasks/projeto/' . $task->getProjeto()->getId());
        }

        return $this->render('novo-task.html.twig', [
            'form' => $form->createView(),
            'projeto' => $task->getProjeto()
        ]);
    }

    /**
     * @Route("/deletar/{task}", name="task_deletar", methods={"GET", "POST"})
     * @ParamConverter("task", class="App\Domain\Model\Task")
     */
    public function deletar(Task $task)
    {
        $idProjeto = $task->getProjeto()->getId();
        $this->taskService->deletar($task);

        $this->addFlash('success','Task Deletada com sucesso');

        return $this->redirect('/tasks/projeto/' . $idProjeto);
    }

}
