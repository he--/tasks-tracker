<?php

namespace App\Infrastructure\Controller;

use App\Domain\Form\Type\StatusType;
use App\Domain\Model\Status;
use \App\Domain\Services\StatusService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/status")
 */
class StatusController extends AbstractController
{
    private StatusService $statusService;

    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * @Route("/listar", name="status_listar")
     */
    public function listarStatus()
    {
        $statusList = $this->statusService->listar();

        return $this->render('lista-status.html.twig', [
            'statusList' => $statusList
        ]);
    }

    /**
     * @Route("/cadastrar", name="status_cadastrar", methods={"GET", "POST"})
     */
    public function cadastrar(Request $request)
    {
        $form = $this->createForm(StatusType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $status =  $form->getData();
            $this->statusService->salvar($status);

            $this->addFlash('success','Status Cadastrada com sucesso');

            return $this->redirect('/status/listar');
        }

        return $this->render('novo-status.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editar/{status}", name="status_editar", methods={"GET", "POST"})
     * @ParamConverter("status", class="App\Domain\Model\Status")
     */
    public function editar(Status $status, Request $request)
    {
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $status =  $form->getData();
            $this->statusService->salvar($status);

            $this->addFlash('success','Status alterado com sucesso');

            return $this->redirect('/status/listar');
        }

        return $this->render('novo-status.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
