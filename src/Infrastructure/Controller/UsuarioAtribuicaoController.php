<?php

namespace App\Infrastructure\Controller;


use App\Domain\Form\Type\UsuarioType;
use App\Domain\Model\Usuario;
use App\Domain\Model\UsuarioAtribuicao;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UsuarioAtribuicaoController
 * @Route("/usuario")
 * @package App\Controller
 */
class UsuarioAtribuicaoController extends AbstractController
{

    /**
     * @Route("/tasks" , name="usuario_tasks")
     */
    public function listarAtribuicoes()
    {
        $usuario = $this->getUser();
        $atribuicoes = $this
            ->getDoctrine()
            ->getRepository(UsuarioAtribuicao::class)
            ->findBy(['usuario' => $usuario->getId()])
        ;

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
