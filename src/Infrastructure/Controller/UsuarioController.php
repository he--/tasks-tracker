<?php


namespace App\Infrastructure\Controller;


use App\Domain\Form\Type\UsuarioType;
use App\Domain\Model\Usuario;
use App\Domain\Services\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/me")
 */
class UsuarioController extends AbstractController
{
    /**
     * @var UsuarioService
     */
    private UsuarioService $usuarioService;

    /**
     * ProjetoController constructor.
     * @param UsuarioService $usuarioService
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * @Route("/cadastro", name="cadastrar_usuario", methods={"GET", "POST"})
     */
    public function cadastrar(Request $request)
    {
        $form = $this->createForm(UsuarioType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $usuario= $form->getData();

            $role = $form->get('roles')->getData();

            $usuario->setRoles(array($role));

            $this->usuarioService->salvar($usuario);

            $this->addFlash('success','Usuario cadastrado com sucesso');

            return $this->redirectToRoute('usuario_listar');
        }
        return $this->render('usuario-cadastro.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/deletar/{id}", name="deletar_usuario", methods={"GET", "POST"})
     * @ParamConverter("id", class="App\Domain\Model\Usuario")
     */
    public function deletar(Usuario $id)
    {
        $this->usuarioService->delete($id);

        $this->addFlash('success','Usuario deletado com sucesso');

        return $this->redirect('/usuario/listar');
    }

    /**
     * @Route("/editar/{usuario}", name="editar_usuario", methods={"GET", "POST"})
     * @ParamConverter("usuario", class="App\Domain\Model\Usuario")
     */
    public function editar(Usuario $usuario, Request $request)
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $usuario =  $form->getData();

            $role = $form->get('roles')->getData();

            $usuario->setRoles(array($role));

            $this->usuarioService->editar($usuario);

            $this->addFlash('success','Usuario Cadastrado com sucesso');

            return $this->redirect('/usuario/listar');
        }

        return $this->render('usuario-cadastro.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    //metodo nao funcionando;
    /**
     * @Route("/listar/usuario" , name="listar_usuarios")
     */
    public function listar()
    {
        $usuarios = $this->usuarioService->listar();

        return $this->render('usuarios-listar.html.twig',
            [
                'usuarios' => $usuarios,
            ]
        );
    }
}