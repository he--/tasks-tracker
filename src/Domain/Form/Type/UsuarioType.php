<?php


namespace App\Domain\Form\Type;


use App\Domain\Model\Usuario;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Nome do Usuario']])
            ->add('email', EmailType::class, ['label' => false, 'attr' => ['placeholder' => 'E-mail']])
            ->add('password', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Senha']])
            ->add('roles', ChoiceType::class, array(
                'mapped' => false,
                'required' => true,
                'label'    => 'User Type',
                'choices' => array(
                    'Administrador' => 'ROLE_ADMIN',
                    'Usuario' => 'ROLE_USER',
                ),
                'expanded'   => true,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class
        ]);
    }
}