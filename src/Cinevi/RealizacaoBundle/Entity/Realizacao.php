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
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"}, inversedBy="realizacaos")
     **/
    protected $user;

    /**
     * @ORM\Column(type="string")
     **/
    protected $titulo;

    /**
      * @ORM\Column(type="text")
     **/
    protected $sinopse;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Modalidade", cascade={"merge"})
     **/
    protected $modalidade;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $professor;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     **/
    protected $genero;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $locacoes;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $captacao;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $detalhesCaptacao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Projeto", cascade={"persist","merge"}, mappedBy="realizacao")
     **/
    protected $projeto;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\CopiaFinal", cascade={"persist","merge"}, mappedBy="realizacao")
     **/
    protected $copiaFinal;


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
     * Set titulo
     *
     * @param string $titulo
     * @return Realizacao
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set sinopse
     *
     * @param string $sinopse
     * @return Realizacao
     */
    public function setSinopse($sinopse)
    {
        $this->sinopse = $sinopse;

        return $this;
    }

    /**
     * Get sinopse
     *
     * @return string
     */
    public function getSinopse()
    {
        return $this->sinopse;
    }

    /**
     * Set locacoes
     *
     * @param string $locacoes
     * @return Realizacao
     */
    public function setLocacoes($locacoes)
    {
        $this->locacoes = $locacoes;

        return $this;
    }

    /**
     * Get locacoes
     *
     * @return string
     */
    public function getLocacoes()
    {
        return $this->locacoes;
    }

    /**
     * Set captacao
     *
     * @param string $captacao
     * @return Realizacao
     */
    public function setCaptacao($captacao)
    {
        $this->captacao = $captacao;

        return $this;
    }

    /**
     * Get captacao
     *
     * @return string
     */
    public function getCaptacao()
    {
        return $this->captacao;
    }

    /**
     * Set detalhesCaptacao
     *
     * @param string $detalhesCaptacao
     * @return Realizacao
     */
    public function setDetalhesCaptacao($detalhesCaptacao)
    {
        $this->detalhesCaptacao = $detalhesCaptacao;

        return $this;
    }

    /**
     * Get detalhesCaptacao
     *
     * @return string
     */
    public function getDetalhesCaptacao()
    {
        return $this->detalhesCaptacao;
    }

    /**
     * Set user
     *
     * @param \Cinevi\SecurityBundle\Entity\User $user
     * @return Realizacao
     */
    public function setUser(\Cinevi\SecurityBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Cinevi\SecurityBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set professor
     *
     * @param \Cinevi\SecurityBundle\Entity\User $professor
     * @return Realizacao
     */
    public function setProfessor(\Cinevi\SecurityBundle\Entity\User $professor = null)
    {
        $this->professor = $professor;

        return $this;
    }

    /**
     * Get professor
     *
     * @return \Cinevi\SecurityBundle\Entity\User
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * Set genero
     *
     * @param array $genero
     * @return Realizacao
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return array
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set projeto
     *
     * @param \Cinevi\RealizacaoBundle\Entity\Projeto $projeto
     * @return Realizacao
     */
    public function setProjeto(\Cinevi\RealizacaoBundle\Entity\Projeto $projeto = null)
    {
        $this->projeto = $projeto;

        return $this;
    }

    /**
     * Get projeto
     *
     * @return \Cinevi\RealizacaoBundle\Entity\Projeto
     */
    public function getProjeto()
    {
        return $this->projeto;
    }

    /**
     * Set copiaFinal
     *
     * @param \Cinevi\RealizacaoBundle\Entity\CopiaFinal $copiaFinal
     * @return Realizacao
     */
    public function setCopiaFinal(\Cinevi\RealizacaoBundle\Entity\CopiaFinal $copiaFinal = null)
    {
        $this->copiaFinal = $copiaFinal;

        return $this;
    }

    /**
     * Get copiaFinal
     *
     * @return \Cinevi\RealizacaoBundle\Entity\CopiaFinal
     */
    public function getCopiaFinal()
    {
        return $this->copiaFinal;
    }

    /**
     * Set modalidade
     *
     * @param \Cinevi\RealizacaoBundle\Entity\Modalidade $modalidade
     *
     * @return Realizacao
     */
    public function setModalidade(\Cinevi\RealizacaoBundle\Entity\Modalidade $modalidade = null)
    {
        $this->modalidade = $modalidade;

        return $this;
    }

    /**
     * Get modalidade
     *
     * @return \Cinevi\RealizacaoBundle\Entity\Modalidade
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }
}
