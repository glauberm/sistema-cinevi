<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realizacao_realizacoes")
 */
class Realizacao
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\Column(type="string")
     **/
    protected $titulo;

    /**
      * @ORM\Column(type="string")
     **/
    protected $sinopse;

    /**
     * @ORM\Column(type="string")
     **/
    protected $modalidade;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $professor;

    /**
     * @ORM\Column(type="string")
     **/
    protected $genero;

    /**
     * @ORM\Column(type="text")
     **/
    protected $locacoes;

    /**
     * @ORM\Column(type="string")
     **/
    protected $captacao;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $detalhesCaptacao;
}
