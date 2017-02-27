<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realizacao_projetos")
 */
class Projeto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Realizacao", cascade={"all"})
     **/
    protected $realizacao;

    /**
     * @ORM\Column(type="date")
     **/
    protected $preProducao;

    /**
     * @ORM\Column(type="date")
     **/
    protected $dataProducao;

    /**
     * @ORM\Column(type="date")
     **/
    protected $posProducao;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $direcao;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $producao;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $fotografia;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $disciplinaFotografia;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $som;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $disciplinaSom;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $arte;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $disciplinaArte;


}
