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
     * @Route("/olamundo/{nome}")
     */
    public function teste(string $nome): Response
    {
       return new Response('Bem vindo :'.$nome);
    }

}
