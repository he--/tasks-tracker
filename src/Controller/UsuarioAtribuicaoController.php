<?php

namespace App\Controller;


use App\Domain\Model\UsuarioAtribuicao;
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

        return $this->render('usuario_tasks.html.twig',
            [
                'atribuicoes' => $atribuicoes,
                'usuario' => $usuario
            ]
        );
    }

}
