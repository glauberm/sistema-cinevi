<?php

namespace Cinevi\ProducaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="producao_copias_finais")
 */
class CopiaFinal
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     **/
    protected $titulo;

    /**
      * @ORM\Column(type="string")
     **/
    protected $sinopse;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\Column(type="string")
     **/
    protected $realizacao;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $professor;

    /**
     * @ORM\Column(type="string")
     **/
    protected $cromia;

    /**
     * @ORM\Column(type="string")
     **/
    protected $proporcao;

    /**
     * @ORM\Column(type="string")
     **/
    protected $captacao;

    /**
     * @ORM\Column(type="string")
     **/
    protected $formato;

    /**
     * @ORM\Column(type="string")
     **/
    protected $formatoNativo;

    /**
     * @ORM\Column(type="string")
     **/
    protected $codec;

    /**
     * @ORM\Column(type="string")
     **/
    protected $container;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $taxaBits;

    /**
     * @ORM\Column(type="string")
     **/
    protected $velocidade;

    /**
     * @ORM\Column(type="string")
     **/
    protected $som;

    /**
     * @ORM\Column(type="string")
     **/
    protected $resolucaoAudio;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $dcp;

    /**
     * @ORM\Column(type="string")
     **/
    protected $suporteMatriz;

    /**
     * @ORM\Column(type="string")
     **/
    protected $camera;

    /**
     * @ORM\Column(type="string")
     **/
    protected $captacaoSom;

    /**
     * @ORM\Column(type="string")
     **/
    protected $softwareEdicao;

    /**
     * @ORM\Column(type="text")
     **/
    protected $locacoes;

    /**
     * @ORM\Column(type="decimal", scale=2)
     **/
    protected $orcamento;

    /**
     * @ORM\Column(type="simple_array")
     **/
    protected $fontesFinanciamento;

    /**
     * @ORM\Column(type="text")
     **/
    protected $apoiadores;

    /**
     * @ORM\Column(type="string")
     **/
    protected $genero;

    /**
     * @ORM\Column(type="integer")
     **/
    protected $duracao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\ProducaoBundle\Entity\MateriaisDivulgacao", cascade={"persist","merge"})
     **/
    protected $materiaisDivulgacao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\ProducaoBundle\Entity\FichaTecnica", cascade={"persist","merge"})
     **/
    protected $fichaTecnica;

    /**
     * @ORM\Column(type="text")
     **/
    protected $elenco;

    /**
     * @ORM\Column(type="text")
     **/
    protected $outrasInformacoes;

    /**
     * @ORM\Column(type="text")
     **/
    protected $participacoes;

    /**
     * @ORM\Column(type="text")
     **/
    protected $premios;
}
