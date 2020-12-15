<?php

namespace App\Infrastructure\Controller;

use App\Domain\Form\Type\TaskType;
use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use App\Domain\Model\UsuarioAtribuicao;
use App\Domain\Services\TaskService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{


    /**
     * @var TaskService
     */
    private TaskService $taskService;

    /**
     * ProjetoController constructor.
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @Route("/listar/{id}")
     */
    public function listTasks()
    {
        $this->taskService->listar();
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
     * @Route("/cadastrar/{projeto}", name="cadastrar_task", methods={"GET", "POST"})
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

            return $this->redirect('/projetos/visualizar/'.$projeto->getId());
        }

        return $this->render('novo-task.html.twig', [
            'form' => $form->createView(), 'projeto' => $projeto
        ]);
    }

    /**
     * @Route("/editar/{task}", name="editar_task", methods={"GET", "POST"})
     * @ParamConverter("task", class="App\Domain\Model\Task")
     */
    public function editar(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $task =  $form->getData();
            $this->taskService->salvar($task);

            $this->addFlash('success','Task atualizada com sucesso');

            return $this->redirect('/projetos/listar');
        }

        return $this->render('novo-task.html.twig', [
            'form' => $form->createView(), 'projeto' => $task->getProjeto()
        ]);
    }

    /**
     * @Route("/deletar/{id}", name="deletar_task", methods={"GET", "POST"})
     * @ParamConverter("id", class="App\Domain\Model\Task")
     */
    public function deletarProjetoTask(Task $id)
    {
        $doctrine = $this->getDoctrine()->getManager();

        $this->taskService->delete($id);

        $doctrine->flush();

        $this->addFlash('success','Task Deletada com sucesso');

        return $this->redirect('/projetos/listar');
    }

    /**
     * @Route("/deletar_atribuicao/{atribuicao}", name="deletar_task_atribuicao", methods={"GET", "POST"})
     * @ParamConverter("atribuicao", class="App\Domain\Model\UsuarioAtribuicao")
     */
    public function deletar(UsuarioAtribuicao $atribuicao)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $task = $atribuicao->getTask();

        $doctrine->remove($atribuicao);
        $doctrine->remove($task);
        $doctrine->flush();

        $this->addFlash('success','Task Deletada com sucesso');

        return $this->redirect('/usuario/tasks');
    }

}
