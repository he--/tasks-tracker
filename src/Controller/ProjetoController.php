<?php

namespace App\Controller;

use App\Domain\Model\Projeto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/projetos")
 */
class ProjetoController extends AbstractController
{

    /**
     * @Route("/listar", name="listar_projetos")
     */
    public function listarProjetos()
    {
        $projetos = $this->get('doctrine')->getRepository(Projeto::class)->findAll();

        return $this->render('lista_projetos.html.twig', ['projetos' => $projetos]);
    }

    /**
     * @Route("/editar/{projeto}", name="editar_projetos")
     * @ParamConverter("projeto", class="App\Domain\Model\Projeto")
     * @param Projeto $projeto
     */
    public function editar(Projeto $projeto)
    {
        return $this->render('projeto.html.twig', ['projeto' => $projeto] );
    }
}
