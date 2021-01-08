<?php

namespace App\Application\Controller;


use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use App\Domain\Model\Usuario;
use App\Application\Service\ProjetoServiceImpl;
use App\Infrastructure\Repository\UsuarioRepositoryImpl;
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
     * @var ProjetoServiceImpl $projetosService;
     */
    public ProjetoServiceImpl $projetoService;

    public UsuarioRepositoryImpl $usuarioRepository;

    public function __construct(ProjetoServiceImpl $projetoService, UsuarioRepositoryImpl $usuarioRepository)
    {
        $this->projetoService = $projetoService;
        $this->usuarioRepository = $usuarioRepository;
    }


    /**
     * @Route("/index", name="index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {

        $numeroProjetos = $this->projetoService->getNumroDeProjetos();
        $numeroUsuario = $this->usuarioRepository->getNumeroUsers();

        return $this->render(
            'index.html.twig',
            [
                'numeroProjeto' => $numeroProjetos,
                'numeroUsuarios' => $numeroUsuario
            ]
        );
    }

}
