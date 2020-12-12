<?php

namespace App\Infrastructure\Controller;


use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use App\Domain\Model\Usuario;
use App\Domain\Services\ProjetoService;
use App\Infrastructure\Repository\UsuarioRepository;
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
     * @var ProjetoService $projetosService;
     */
    public ProjetoService $projetoService;

    public UsuarioRepository $usuarioRepository;

    public function __construct(ProjetoService $projetoService, UsuarioRepository $usuarioRepository)
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
