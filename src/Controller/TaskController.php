<?php

namespace App\Controller;

use App\Domain\Form\Type\TaskType;
use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use App\Domain\Model\UsuarioAtribuicao;
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
     * @Route("/usuario/{id}")
     */
    public function listTasks()
    {


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
            $doctrine = $this->getDoctrine()->getManager();

            $doctrine->persist($task);
            $doctrine->flush();

            $this->addFlash('success','Task Cadastrada com sucesso');

            return $this->redirect('/projetos/visualizar/'.$projeto->getId());
        }

        return $this->render('novo-task.html.twig', [
            'form' => $form->createView(), 'projeto' => $projeto
        ]);
    }

}
