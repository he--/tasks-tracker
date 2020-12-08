<?php

namespace App\Controller;

use App\Domain\Form\Type\ProjetoType;
use App\Domain\Model\Projeto;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/projetos")
 */
class ProjetoController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/listar", name="listar_projetos")
     */
    public function listarProjetos()
    {
        $projetos = $this->get('doctrine')->getRepository(Projeto::class)->findAll();

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
            $projeto =  $form->getData();
            $doctrine = $this->getDoctrine()->getManager();

            $doctrine->persist($projeto);
            $doctrine->flush();

            $this->addFlash('success','Projeto Salvo com sucesso');

            return $this->redirectToRoute('listar_projetos');
        }

        return $this->render('novo-projeto.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/visualizar/{projeto}", name="visualizar_projetos")
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
            $doctrine = $this->getDoctrine()->getManager();

            $doctrine->persist($projeto);
            $doctrine->flush();

            $this->addFlash('success','Projeto Salvo com sucesso');

            return $this->redirectToRoute('listar_projetos');
        }

        return $this->render('novo-projeto.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
