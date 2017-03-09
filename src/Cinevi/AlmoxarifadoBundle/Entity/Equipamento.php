<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="almoxarifado_equipamentos")
 */
class Equipamento
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Categoria", cascade={"merge"}, inversedBy="equipamentos")
     **/
    protected $categoria;

    /**
     * @ORM\Column(type="string", unique=true)
     **/
    protected $codigo;

    /**
     * @ORM\Column(type="string")
     **/
    protected $nome;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $especificacao;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $fabricante;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $modelo;

    /**
     * @ORM\Column(type="integer", nullable=true, unique=true)
     **/
    protected $patrimonio;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $nSerie;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $acessorios;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $obs;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $manutencao;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Equipamento
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Equipamento
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set especificacao
     *
     * @param string $especificacao
     * @return Equipamento
     */
    public function setEspecificacao($especificacao)
    {
        $this->especificacao = $especificacao;

        return $this;
    }

    /**
     * Get especificacao
     *
     * @return string
     */
    public function getEspecificacao()
    {
        return $this->especificacao;
    }

    /**
     * Set fabricante
     *
     * @param string $fabricante
     * @return Equipamento
     */
    public function setFabricante($fabricante)
    {
        $this->fabricante = $fabricante;

        return $this;
    }

    /**
     * Get fabricante
     *
     * @return string
     */
    public function getFabricante()
    {
        return $this->fabricante;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Equipamento
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set patrimonio
     *
     * @param integer $patrimonio
     * @return Equipamento
     */
    public function setPatrimonio($patrimonio)
    {
        $this->patrimonio = $patrimonio;

        return $this;
    }

    /**
     * Get patrimonio
     *
     * @return integer
     */
    public function getPatrimonio()
    {
        return $this->patrimonio;
    }

    /**
     * Set nSerie
     *
     * @param string $nSerie
     * @return Equipamento
     */
    public function setNSerie($nSerie)
    {
        $this->nSerie = $nSerie;

        return $this;
    }

    /**
     * Get nSerie
     *
     * @return string
     */
    public function getNSerie()
    {
        return $this->nSerie;
    }

    /**
     * Set acessorios
     *
     * @param string $acessorios
     * @return Equipamento
     */
    public function setAcessorios($acessorios)
    {
        $this->acessorios = $acessorios;

        return $this;
    }

    /**
     * Get acessorios
     *
     * @return string
     */
    public function getAcessorios()
    {
        return $this->acessorios;
    }

    /**
     * Set obs
     *
     * @param string $obs
     * @return Equipamento
     */
    public function setObs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    /**
     * Get obs
     *
     * @return string
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Set manutencao
     *
     * @param boolean $manutencao
     * @return Equipamento
     */
    public function setManutencao($manutencao)
    {
        $this->manutencao = $manutencao;

        return $this;
    }

    /**
     * Get manutencao
     *
     * @return boolean
     */
    public function getManutencao()
    {
        return $this->manutencao;
    }

    /**
     * Set categoria
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Categoria $categoria
     * @return Equipamento
     */
    public function setCategoria(\Cinevi\AlmoxarifadoBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Cinevi\AlmoxarifadoBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
