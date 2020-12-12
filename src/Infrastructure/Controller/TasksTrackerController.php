<?php

namespace App\Infrastructure\Controller;


use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use App\Domain\Model\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/task")
 */
class TasksTrackerController extends AbstractController
{

    /**
     * @Route("/teste", name="task_teste")
     */
    public function teste(): Response
    {

        $doctrine = $this->get('doctrine');


//        $status = $doctrine->getManager()->getRepository(Status::class)->find(1);
//
//        $task = new Task();
//        $task->setStatus($status);
//        $task->setNome("Criar Crud para os status");
//        $task->setDescircao("Possibilitar o gerente da empresa adicionar um status para as tasks");
//        $task->setDtCadastro(new \DateTime());
//        $projeto->addTask($task);
//        $task->setProjeto($projeto);

//        $usuario = new Usuario();
//        $usuario->setNome('Hélio Cardoso');
//        $usuario->setEmail('heliosouza@gmail.com');
//        $usuario->setRoles(['ROLE_ADMIM1']);
//



       $result =  $doctrine->getRepository(Usuario::class)->findAll();
       dump($result);exit;
    }

    /**
     * @Route("/index", name="index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

}
