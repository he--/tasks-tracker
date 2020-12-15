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
     * @Route("/teste/{nome}")
     */
    public function teste(string $nome): Response
    {
        $projeto = new Projeto();
        $projeto->setNome($nome);
        $projeto->setDescricao("hehhehe");
        $projeto->setDtCadastro(new \DateTime());
        $projeto->setGerente("Otto");

        $em = $this->getDoctrine()->getManager();
        $em->persist($projeto);


        $task = new Task();
        $task ->setNome("Fazer Crud");
        $task ->setDescricao("Construir");
        $task ->setProjeto($projeto);
        $task ->setDtCadastro(new \DateTime());
        $task ->setDtConclusao(new \DateTime());

//        $status = new Status();
//        $status->setDescricao("Status");
//        $em->persist($status);

//        $status = $em->getRepository(Status::class)->find(1);
//
//        $task->setStatus($status);
        $em->persist($task);
        $em->flush();

        $projeto = $em->getRepository(Projeto::class)->findAll();

        dump($projeto);exit;

        return new Response('Bem vindo :'.$nome);
    }

}
