<?php

namespace App\Domain\Form\Type;

use App\Domain\Model\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('nome', TextType::class, ['label' => 'Nome'])
            ->add('password', PasswordType::class, ['label' => 'Senha'])
            ->add('roles', ChoiceType::class, ['label' => 'Permissão',
                //'multiple' => false,
                'choices'  => [
                    'ROLE_ADMIM' => 'ROLE_ADMIM',
                    'ROLE_COMUN' => 'ROLE_COMUM',
                ],
            ])
            ->add('salvar', SubmitType::class);
            
            $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return is_array($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
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
