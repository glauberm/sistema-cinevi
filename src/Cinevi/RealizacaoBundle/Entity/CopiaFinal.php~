<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realizacao_copias_finais")
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
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Realizacao", cascade={"all"})
     **/
    protected $realizacao;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $cromia;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $proporcao;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $formato;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $formatoDigitalNativo;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $codec;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $container;

    /**
     * @ORM\Column(type="integer", nullable=true)
     **/
    protected $taxaBits;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $velocidade;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $som;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $resolucaoAudioDigital;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $dcp;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $suporteMatrizDigital;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $camera;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $captacaoSom;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     **/
    protected $softwareEdicao;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     **/
    protected $orcamento;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     **/
    protected $fontesFinanciamento;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $apoiadores;

    /**
     * @ORM\Column(type="integer", nullable=true)
     **/
    protected $duracao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\FichaTecnica", cascade={"persist","merge"})
     **/
    protected $fichaTecnica;


}
