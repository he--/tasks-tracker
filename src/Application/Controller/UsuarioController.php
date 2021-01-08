<?php

namespace App\Application\Controller;


use App\Domain\Model\Usuario;
use App\Domain\Model\UsuarioAtribuicao;
use App\Domain\Service\UsuarioService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UsuarioController
 * @Route("/usuario")
 * @package App\Controller
 */
class UsuarioController extends AbstractController
{

    /**
     * @var UsuarioService
     */
    private UsuarioService $usuarioService;

    /**
     * UsuarioController constructor.
     * @param UsuarioService $usuarioService
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * @Route("/tasks" , name="usuario_tasks")
     */
    public function listarAtribuicoes()
    {
        $usuario = $this->getUser();
        $atribuicoes = $this->usuarioService.atribuicoes($usuario.getId());

        return $this->render('usuario-tasks.html.twig',
            [
                'atribuicoes' => $atribuicoes,
                'usuario' => $usuario
            ]
        );
    }

    /**
     * @Route("/listar" , name="usuario_listar")
     */
    public function listarUsuarios()
    {
        $usuarios = $this
            ->getDoctrine()
            ->getRepository(Usuario::class)
            ->findAll()
        ;

        return $this->render('usuarios-listar.html.twig',
            [
                'usuarios' => $usuarios,
            ]
        );
    }

}
