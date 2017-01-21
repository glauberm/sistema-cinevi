<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="almoxarifado_projetos")
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
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\Column(type="string")
     **/
    protected $nome;

    /**
     * @ORM\Column(type="string")
     **/
    protected $modalidade;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $professor;

    /**
     * @ORM\Column(type="string")
     **/
    protected $captacao;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $detalhesCaptacao;

    /**
     * @ORM\Column(type="string")
     **/
    protected $genero;

    /**
     * @ORM\Column(type="string")
     **/
    protected $locacao;

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
     * @ORM\OneToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Direcao", cascade={"all"})
     **/
    protected $direcao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Producao", cascade={"all"})
     **/
    protected $producao;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Fotografia", cascade={"all"})
     **/
    protected $fotografia;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Som", cascade={"all"})
     **/
    protected $som;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Arte", cascade={"all"})
     **/
    protected $arte;


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
     * @return Projeto
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
     * Set user
     *
     * @param \Cinevi\SecurityBundle\Entity\User $user
     * @return Projeto
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
     * Set modalidade
     *
     * @param string $modalidade
     * @return Projeto
     */
    public function setModalidade($modalidade)
    {
        $this->modalidade = $modalidade;

        return $this;
    }

    /**
     * Get modalidade
     *
     * @return string
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }

    /**
     * Set captacao
     *
     * @param string $captacao
     * @return Projeto
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
     * @return Projeto
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
     * Set genero
     *
     * @param string $genero
     * @return Projeto
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set locacao
     *
     * @param string $locacao
     * @return Projeto
     */
    public function setLocacao($locacao)
    {
        $this->locacao = $locacao;

        return $this;
    }

    /**
     * Get locacao
     *
     * @return string
     */
    public function getLocacao()
    {
        return $this->locacao;
    }

    /**
     * Set preProducao
     *
     * @param \DateTime $preProducao
     * @return Projeto
     */
    public function setPreProducao($preProducao)
    {
        $this->preProducao = $preProducao;

        return $this;
    }

    /**
     * Get preProducao
     *
     * @return \DateTime
     */
    public function getPreProducao()
    {
        return $this->preProducao;
    }

    /**
     * Set dataProducao
     *
     * @param \DateTime $dataProducao
     * @return Projeto
     */
    public function setDataProducao($dataProducao)
    {
        $this->dataProducao = $dataProducao;

        return $this;
    }

    /**
     * Get dataProducao
     *
     * @return \DateTime
     */
    public function getDataProducao()
    {
        return $this->dataProducao;
    }

    /**
     * Set posProducao
     *
     * @param \DateTime $posProducao
     * @return Projeto
     */
    public function setPosProducao($posProducao)
    {
        $this->posProducao = $posProducao;

        return $this;
    }

    /**
     * Get posProducao
     *
     * @return \DateTime
     */
    public function getPosProducao()
    {
        return $this->posProducao;
    }

    /**
     * Set direcao
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Direcao $direcao
     * @return Projeto
     */
    public function setDirecao(\Cinevi\AlmoxarifadoBundle\Entity\Direcao $direcao = null)
    {
        $this->direcao = $direcao;

        return $this;
    }

    /**
     * Get direcao
     *
     * @return \Cinevi\AlmoxarifadoBundle\Entity\Direcao
     */
    public function getDirecao()
    {
        return $this->direcao;
    }

    /**
     * Set producao
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Producao $producao
     * @return Projeto
     */
    public function setProducao(\Cinevi\AlmoxarifadoBundle\Entity\Producao $producao = null)
    {
        $this->producao = $producao;

        return $this;
    }

    /**
     * Get producao
     *
     * @return \Cinevi\AlmoxarifadoBundle\Entity\Producao
     */
    public function getProducao()
    {
        return $this->producao;
    }

    /**
     * Set fotografia
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Fotografia $fotografia
     * @return Projeto
     */
    public function setFotografia(\Cinevi\AlmoxarifadoBundle\Entity\Fotografia $fotografia = null)
    {
        $this->fotografia = $fotografia;

        return $this;
    }

    /**
     * Get fotografia
     *
     * @return \Cinevi\AlmoxarifadoBundle\Entity\Fotografia
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * Set som
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Som $som
     * @return Projeto
     */
    public function setSom(\Cinevi\AlmoxarifadoBundle\Entity\Som $som = null)
    {
        $this->som = $som;

        return $this;
    }

    /**
     * Get som
     *
     * @return \Cinevi\AlmoxarifadoBundle\Entity\Som
     */
    public function getSom()
    {
        return $this->som;
    }

    /**
     * Set arte
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Arte $arte
     * @return Projeto
     */
    public function setArte(\Cinevi\AlmoxarifadoBundle\Entity\Arte $arte = null)
    {
        $this->arte = $arte;

        return $this;
    }

    /**
     * Get arte
     *
     * @return \Cinevi\AlmoxarifadoBundle\Entity\Arte
     */
    public function getArte()
    {
        return $this->arte;
    }

    /**
     * Set professor
     *
     * @param \Cinevi\SecurityBundle\Entity\User $professor
     * @return Projeto
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
}
