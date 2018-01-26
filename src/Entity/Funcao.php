<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FuncaoRepository")
 * @ORM\Table(name="realizacao_funcoes")
 */
class Funcao extends Base
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
     * @ORM\OneToMany(targetEntity="App\Entity\Equipe", cascade={"merge", "remove"}, mappedBy="funcao")
     **/
    protected $equipes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\FuncaoHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Funcao
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
     * Set descricao
     *
     * @param string $descricao
     * @return Funcao
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
     * Add equipes
     *
     * @param \App\Entity\Equipe $equipes
     * @return Funcao
     */
    public function addEquipes(\App\Entity\Equipe $equipes)
    {
        $this->equipes[] = $equipes;

        return $this;
    }

    /**
     * Remove equipes
     *
     * @param \App\Entity\Equipe $equipes
     */
    public function removeEquipes(\App\Entity\Equipe $equipes)
    {
        $this->equipes->removeElement($equipes);
    }

    /**
     * Get equipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipes()
    {
        return $this->equipes;
    }

    /**
     * Add historicos
     *
     * @param \App\Entity\FuncaoHistorico $historicos
     * @return Funcao
     */
    public function addHistorico(\App\Entity\FuncaoHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\FuncaoHistorico $historicos
     */
    public function removeHistorico(\App\Entity\FuncaoHistorico $historicos)
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
