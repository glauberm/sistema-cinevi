<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 * @ORM\Table(name="almoxarifado_equipamentos_categorias")
 */
class Categoria extends Base
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
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $descricao;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipamento", cascade={"merge", "remove"}, mappedBy="categoria")
     **/
    protected $equipamentos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CategoriaHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Categoria
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
     * Add equipamentos
     *
     * @param \App\Entity\Equipamento $equipamentos
     * @return Categoria
     */
    public function addEquipamento(\App\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos[] = $equipamentos;

        return $this;
    }

    /**
     * Remove equipamentos
     *
     * @param \App\Entity\Equipamento $equipamentos
     */
    public function removeEquipamento(\App\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos->removeElement($equipamentos);
    }

    /**
     * Get equipamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipamentos()
    {
        return $this->equipamentos;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Categoria
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Add historicos
     *
     * @param \App\Entity\CategoriaHistorico $historicos
     * @return Categoria
     */
    public function addHistorico(\App\Entity\CategoriaHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\CategoriaHistorico $historicos
     */
    public function removeHistorico(\App\Entity\CategoriaHistorico $historicos)
    {
        $this->historicos->removeElement($historicos);
    }

    /**
     * Get historicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoricos()
    {
        return $this->historicos;
    }
}
