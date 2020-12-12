<?php

namespace App\Domain\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Projeto
 *
 * @ORM\Entity
 * @ORM\Table(name="projeto")
 * @package App\Domain\Model
 */
class Projeto
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
     * @var string
     *
     * @ORM\Column(type="string", name="descricao", nullable=false)
     */
    private string $descricao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="nome")
     */
    private string $nome;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="dt_cadastro", )
     *
     */
    private DateTime $dtCadastro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="gerente")
     */
    private string $gerente;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="projeto", fetch="EAGER")
     */
    private Collection $tasks;

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
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getDtCadastro(): string
    {
        return $this->dtCadastro;
    }

    /**
     * @param string $dtCadastro
     */
    public function setDtCadastro(DateTime $dtCadastro): void
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return string
     */
    public function getGerente(): string
    {
        return $this->gerente;
    }

    /**
     * @param string $gerente
     */
    public function setGerente(string $gerente): void
    {
        $this->gerente = $gerente;
    }

    /**
     * @return Collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param ArrayCollection $tasks
     */
    public function setTasks(ArrayCollection $tasks): void
    {
        $this->tasks = $tasks;
    }

    public function addTask(Task $task)
    {
        $task->setProjeto($this);
        $this->tasks->add($task);
    }
}
