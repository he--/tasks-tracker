<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="task")
 */
class Task
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
     * @var Projeto
     *
     * @ORM\ManyToOne(targetEntity="Projeto", inversedBy="tasks")
     * @ORM\JoinColumn(name="projeto", referencedColumnName="id")
     */
    private Projeto $projeto;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="descricao")
     */
    private string $descricao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="nome")
     */
    private string $nome;

    /**
     * @var Status
     *
     * @ORM\OneToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status", referencedColumnName="id", nullable=false)
     */
    private Status $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="dt_cadastro", nullable=false)
     */
    private \DateTime $dtCadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="dt_conclusao", nullable=true)
     */
    private ?\DateTime $dtConclusao;

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
     * @return Projeto
     */
    public function getProjeto(): Projeto
    {
        return $this->projeto;
    }

    /**
     * @param Projeto $projeto
     */
    public function setProjeto(Projeto $projeto): void
    {
        $this->projeto = $projeto;
    }


    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descircao
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

    /**
     * @return \DateTime
     */
    public function getDtCadastro(): \DateTime
    {
        return $this->dtCadastro;
    }

    /**
     * @param \DateTime $dtCadastro
     */
    public function setDtCadastro(\DateTime $dtCadastro): void
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return \DateTime
     */
    public function getDtConclusao():? \DateTime
    {
        return $this->dtConclusao;
    }

    /**
     * @param \DateTime $dtConclusao
     */
    public function setDtConclusao(\DateTime $dtConclusao): void
    {
        $this->dtConclusao = $dtConclusao;
    }
}
