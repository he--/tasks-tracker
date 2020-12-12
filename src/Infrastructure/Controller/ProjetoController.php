<?php

namespace App\Infrastructure\Controller;

use App\Domain\Form\Type\ProjetoType;
use App\Domain\Model\Projeto;
use App\Domain\Services\ProjetoService;
use App\Infrastructure\Repository\UsuarioAtribuicaoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/projetos")
 */
class ProjetoController extends AbstractController
{

    /**
     * @var ProjetoService
     */
    private ProjetoService $projetoService;

    /**
     * ProjetoController constructor.
     * @param ProjetoService $projetoService
     */
    public function __construct(ProjetoService $projetoService)
    {
        $this->projetoService = $projetoService;
    }

    /**
     * @Route("/listar", name="listar_projetos")
     */
    public function listarProjetos()
    {
        $projetos = $this->projetoService->listar();

        return $this->render('lista-projetos.html.twig', ['projetos' => $projetos]);
    }

    /**
     * @Route("/editar/{projeto}", name="editar_projetos")
     * @ParamConverter("projeto", class="App\Domain\Model\Projeto")
     * @param Projeto $projeto
     */
    public function editar(Projeto $projeto, Request $request)
    {
        $form = $this->createForm(ProjetoType::class, $projeto);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $logger = $this->get('logger.alias');
            $logger->info('teste');

            $projeto =  $form->getData();
            $this->projetoService->salvar($projeto);

            $this->addFlash('success','Projeto Salvo com sucesso');

            return $this->redirectToRoute('listar_projetos');
        }

        return $this->render('novo-projeto.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/visualizar/{projeto}", name="visualizar_projeto")
     * @ParamConverter("projeto", class="App\Domain\Model\Projeto")
     * @param Projeto $projeto
     */
    public function visualizar(Projeto $projeto)
    {
        return $this->render('projeto.html.twig', ['projeto' => $projeto]);
    }

    /**
     * @Route("/cadastrar", name="cadastrar_projeto", methods={"GET", "POST"})
     */
    public function cadastrar(Request $request)
    {
        $form = $this->createForm(ProjetoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $projeto =  $form->getData();
            $this->projetoService->salvar($projeto);
            $this->addFlash('success','Projeto Salvo com sucesso');

            return $this->redirectToRoute('listar_projetos');
        }

        return $this->render('novo-projeto.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
