<?php

namespace App\Domain\Form\Type;

use App\Domain\Model\Projeto;
use App\Domain\Model\Status;
use App\Domain\Model\Task;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Nome da Tarefa']])
            ->add('descricao', TextareaType::class)
            ->add('dtCadastro', DateType::class, [
                'label' => 'Data de Cadastro',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('dtConclusao', DateType::class, [
                'label' => 'Data de Conclusao',
                'placeholder' => 'Select a value',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker', 'required' => false],
            ])
            ->add('status',EntityType::class, [
                'class' => Status::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('status')
                        ->orderBy('status.id', 'ASC')
                        ;
                }, 'choice_label' => 'descricao',]
            )
            ->add('salvar', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class
        ]);
    }
}
