<?php

namespace App\Controller;


use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/task")
 */
class TasksTrackerController extends AbstractController
{

    /**
     * @Route("/teste")
     */
    public function teste(): Response
    {

        $doctrine = $this->get('doctrine');

//        $projeto = new Projeto();
//        $projeto->setNome('Grogu Tasks');
//        $projeto->setDescircao('Projeto para criar um gerenciador de tasks simples');
//        $projeto->setDtCadastro(new \DateTime());
//
//        $doctrine->getManager()->persist($projeto);
//        $doctrine->getManager()->flush();

        /**@var \App\Domain\Model\Projeto $projeto*/
        $projeto = $doctrine->getManager()->getRepository(Projeto::class)->find(3);

        foreach ($projeto->getTasks()->toArray() as $task) {
            $taskVo = 'Nome '. $task->getNome().' Status '.$task->getStatus()->getDescricao();
            dump($taskVo);
        }

        exit;


        $status = $doctrine->getManager()->getRepository(Status::class)->find(1);

        $task = new Task();
        $task->setStatus($status);
        $task->setNome("Criar Crud para os status");
        $task->setDescircao("Possibilitar o gerente da empresa adicionar um status para as tasks");
        $task->setDtCadastro(new \DateTime());
        $projeto->addTask($task);
        $task->setProjeto($projeto);


        $doctrine->getManager()->persist($task);
        $doctrine->getManager()->flush();


       $result =  $doctrine->getRepository(Task::class)->findAll();
       dump($result);exit;
    }

}
