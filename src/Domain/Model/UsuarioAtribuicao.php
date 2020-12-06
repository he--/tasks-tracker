<?php

namespace App\Domain\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario_atribuicao")
 */
class UsuarioAtribuicao
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    private Usuario $usuario;

    private Task $task;

    private \DateTime $dtAtribuicao;

    private Status $status;

}
