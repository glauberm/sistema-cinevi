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
     * @ORM\Column(type="string")
     **/
    protected $nome;

    /**
     * @ORM\Column(type="integer", nullable=true)
     **/
    protected $patrimonio;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Categoria", cascade={"merge"})
     **/
    protected $categoria;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $manutencao;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $uso;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $consumivel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     **/
    protected $obs;



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
     * Set uso
     *
     * @param boolean $uso
     * @return Equipamento
     */
    public function setUso($uso)
    {
        $this->uso = $uso;

        return $this;
    }

    /**
     * Get uso
     *
     * @return boolean
     */
    public function getUso()
    {
        return $this->uso;
    }

    /**
     * Set consumivel
     *
     * @param boolean $consumivel
     * @return Equipamento
     */
    public function setConsumivel($consumivel)
    {
        $this->consumivel = $consumivel;

        return $this;
    }

    /**
     * Get consumivel
     *
     * @return boolean
     */
    public function getConsumivel()
    {
        return $this->consumivel;
    }

    /**
     * Set obs
     *
     * @param integer $obs
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
     * @return integer
     */
    public function getObs()
    {
        return $this->obs;
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
