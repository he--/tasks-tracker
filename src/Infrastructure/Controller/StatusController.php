<?php

namespace App\Infrastructure\Controller;

use App\Domain\Services\StatusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Domain\Model\Status;
use App\Domain\Form\Type\StatusType;

/**
 * Class StatusController
 * @Route("/status")
 * @package App\Controller
 */
class StatusController extends AbstractController
{

    private StatusService $statusService;
    
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }
    


    /**
     * @Route("/listar" , name="status_listar")
     */
    public function listar()
    {
        
        $status = $this->statusService->listar();

        return $this->render('status-listar.html.twig',
            [
                'status' => $status,
            ]
        );
    }
    
    /**
     * @Route("/cadastrar", name="status_cadastrar")
     */
    public function cadastrar(Request $request)
    {
        $form = $this->createForm(StatusType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $status =  $form->getData();
            $this->statusService->salvar($status);
            $this->addFlash('success','Status Salvo com sucesso');
            
            return $this->redirectToRoute('status_listar');
        }
        
        return $this->render('novo-status.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/editar/{status}", name="editar_status")
     * @ParamConverter("status", class="App\Domain\Model\Status")
     * @param Status $status
     */
    public function editar(Status $status, Request $request)
    {
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $status =  $form->getData();
            $this->statusService->salvar($status);
            
            $this->addFlash('success','Status Alterado com sucesso');
            
            return $this->redirectToRoute('status_listar');
        }
        
        return $this->render('novo-status.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/remover/{status}", name="remover_status")
     * @ParamConverter("status", class="App\Domain\Model\Status")
     * @param Status $status
     */
    public function remover(Status $status, Request $request)
    {
        
        $this->statusService->remover($status);
        
        $this->addFlash('success','Status Removido com sucesso');
        
        return $this->redirectToRoute('status_listar');
        
    }
    


}
