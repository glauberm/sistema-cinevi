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
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Direcao", cascade={"all"})
     **/
    protected $direcao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\AssistenciaDirecao", cascade={"all"})
     **/
    protected $assistenciaDirecao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Producao", cascade={"all"})
     **/
    protected $producao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\AssistenciaProducao", cascade={"all"})
     **/
    protected $assistenciaProducao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Roteiro", cascade={"all"})
     **/
    protected $roteiro;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Argumento", cascade={"all"})
     **/
    protected $argumento;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Montagem", cascade={"all"})
     **/
    protected $montagem;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\AssistenciaMontagem", cascade={"all"})
     **/
    protected $assistenciaMontagem;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Fotografia", cascade={"all"})
     **/
    protected $fotografia;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Camera", cascade={"all"})
     **/
    protected $camera;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Still", cascade={"all"})
     **/
    protected $still;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\AssistenciaFotografia", cascade={"all"})
     **/
    protected $assistenciaFotografia;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Som", cascade={"all"})
     **/
    protected $som;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\EdicaoSom", cascade={"all"})
     **/
    protected $edicaoSom;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\TecnicoSom", cascade={"all"})
     **/
    protected $tecnicoSom;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Musica", cascade={"all"})
     **/
    protected $musica;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\AssistenciaSom", cascade={"all"})
     **/
    protected $assistenciaSom;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Arte", cascade={"all"})
     **/
    protected $arte;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\AssistenciaArte", cascade={"all"})
     **/
    protected $assistenciaArte;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Figurino", cascade={"all"})
     **/
    protected $figurino;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\AssistenciaFigurino", cascade={"all"})
     **/
    protected $assistenciaFigurino;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Eletricista", cascade={"all"})
     **/
    protected $eletricista;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Maquinista", cascade={"all"})
     **/
    protected $maquinista;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Logger", cascade={"all"})
     **/
    protected $logger;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Plato", cascade={"all"})
     **/
    protected $plato;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Continuidade", cascade={"all"})
     **/
    protected $continuidade;


}
