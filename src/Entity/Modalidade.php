<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModalidadeRepository")
 * @ORM\Table(name="realizacao_modalidades")
 * @ORM\HasLifecycleCallbacks()
 */
class Modalidade extends Base
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
     * @ORM\OneToMany(targetEntity="App\Entity\Realizacao", cascade={"merge", "remove"}, mappedBy="modalidade")
     **/
    protected $realizacaos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ModalidadeHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->realizacaos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Modalidade
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
     * @return Modalidade
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
     * Add realizacaos
     *
     * @param \App\Entity\Realizacao $realizacaos
     * @return Modalidade
     */
    public function addRealizacao(\App\Entity\Realizacao $realizacaos)
    {
        $this->realizacaos[] = $realizacaos;

        return $this;
    }

    /**
     * Remove realizacaos
     *
     * @param \App\Entity\Realizacao $realizacaos
     */
    public function removeRealizacao(\App\Entity\Realizacao $realizacaos)
    {
        $this->realizacaos->removeElement($realizacaos);
    }

    /**
     * Get realizacaos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRealizacaos()
    {
        return $this->realizacaos;
    }

    /**
     * Add historicos
     *
     * @param \App\Entity\ModalidadeHistorico $historicos
     * @return Modalidade
     */
    public function addHistorico(\App\Entity\ModalidadeHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\ModalidadeHistorico $historicos
     */
    public function removeHistorico(\App\Entity\ModalidadeHistorico $historicos)
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
