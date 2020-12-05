<?php
/**
 * Criado por Vox Tecnologia.
 * User: Helio Cardoso <helio@voxtecnologia.com.br>
 * Date: 05/12/20
 */

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

}
