<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("usuario_atribuicao")
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

    /**
     * @var Usuario
     *
     * @ORM\OneToOne(targetEntity="Usuario", fetch="EAGER")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     *
     */
    private Usuario $usuario;

    /**
     * @var Task
     *
     * @ORM\OneToOne(targetEntity="Task")
     * @ORM\JoinColumn(name="task", referencedColumnName="id")
     */
    private Task $task;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="dt_atribuicao")
     */
    private \DateTime $dtAtribuicao;

    /**
     * @var Status
     *
     * @ORM\OneToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    private Status $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * @param Task $task
     */
    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    /**
     * @return \DateTime
     */
    public function getDtAtribuicao(): \DateTime
    {
        return $this->dtAtribuicao;
    }

    /**
     * @param \DateTime $dtAtribuicao
     */
    public function setDtAtribuicao(\DateTime $dtAtribuicao): void
    {
        $this->dtAtribuicao = $dtAtribuicao;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }
}
