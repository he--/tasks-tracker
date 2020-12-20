<?php

namespace App\Infrastructure\Controller;

use App\Domain\Form\Type\UsuarioType;
use App\Domain\Model\Usuario;
use App\Domain\Model\UsuarioAtribuicao;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Services\UsuarioService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class UsuarioAtribuicaoController
 * @Route("/usuario")
 * @package App\Controller
 */
class UsuarioAtribuicaoController extends AbstractController
{

    private UsuarioService $usuarioService;
    
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
//         $usuarios = $this
//             ->getDoctrine()
//             ->getRepository(Usuario::class)
//             ->findAll()
//         ;
        
        $usuarios = $this->usuarioService->listar();

        return $this->render('usuarios-listar.html.twig',
            [
                'usuarios' => $usuarios,
            ]
        );
    }
    
    /**
     * @Route("/cadastrar", name="usuario_cadastrar")
     */
    public function cadastrar(Request $request)
    {
        $form = $this->createForm(UsuarioType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $usuario =  $form->getData();
            $this->usuarioService->salvar($usuario);
            $this->addFlash('success','Usuário Salvo com sucesso');
            
            return $this->redirectToRoute('usuario_listar');
        }
        
        return $this->render('novo-usuario.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/editar/{usuario}", name="editar_usuarios")
     * @ParamConverter("usuario", class="App\Domain\Model\Usuario")
     * @param Usuario $usuario
     */
    public function editar(Usuario $usuario, Request $request)
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $usuario =  $form->getData();
            $this->usuarioService->salvar($usuario);
            
            $this->addFlash('success','Usuário Alterado com sucesso');
            
            return $this->redirectToRoute('usuario_listar');
        }
        
        return $this->render('novo-usuario.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/remover/{usuario}", name="remover_usuarios")
     * @ParamConverter("usuario", class="App\Domain\Model\Usuario")
     * @param Usuario $usuario
     */
    public function remover(Usuario $usuario, Request $request)
    {
 
            $this->usuarioService->remover($usuario);
            
            $this->addFlash('success','Usuário Removido com sucesso');
            
            return $this->redirectToRoute('usuario_listar');

    }

}
