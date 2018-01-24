<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetoRepository")
 * @ORM\Table(name="realizacao_projetos")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\OneToOne(targetEntity="App\Entity\Realizacao", cascade={"all"}, inversedBy="projeto")
     **/
    protected $realizacao;

    /**
     * @ORM\Column(type="date", nullable=true)
     **/
    protected $preProducao;

    /**
     * @ORM\Column(type="date", nullable=true)
     **/
    protected $dataProducao;

    /**
     * @ORM\Column(type="date", nullable=true)
     **/
    protected $posProducao;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_direcao")
     **/
    protected $direcao;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_producao")
     **/
    protected $producao;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_fotografia")
     **/
    protected $fotografia;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $disciplinaFotografia;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_som")
     **/
    protected $som;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $disciplinaSom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"merge"})
      * @ORM\JoinTable(name="realizacao_projetos_arte")
     **/
    protected $arte;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $disciplinaArte;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CopiaFinal", cascade={"merge", "remove"}, mappedBy="projeto")
     **/
    protected $copiaFinal;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CalendarEvent", cascade={"merge", "remove"}, mappedBy="projeto")
     **/
    protected $calendarEvents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProjetoHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->direcao = new \Doctrine\Common\Collections\ArrayCollection();
        $this->producao = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fotografia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->som = new \Doctrine\Common\Collections\ArrayCollection();
        $this->arte = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->getRealizacao()->getTitulo();
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
     * Set disciplinaFotografia
     *
     * @param boolean $disciplinaFotografia
     * @return Projeto
     */
    public function setDisciplinaFotografia($disciplinaFotografia)
    {
        $this->disciplinaFotografia = $disciplinaFotografia;

        return $this;
    }

    /**
     * Get disciplinaFotografia
     *
     * @return boolean
     */
    public function getDisciplinaFotografia()
    {
        return $this->disciplinaFotografia;
    }

    /**
     * Set disciplinaSom
     *
     * @param boolean $disciplinaSom
     * @return Projeto
     */
    public function setDisciplinaSom($disciplinaSom)
    {
        $this->disciplinaSom = $disciplinaSom;

        return $this;
    }

    /**
     * Get disciplinaSom
     *
     * @return boolean
     */
    public function getDisciplinaSom()
    {
        return $this->disciplinaSom;
    }

    /**
     * Set disciplinaArte
     *
     * @param boolean $disciplinaArte
     * @return Projeto
     */
    public function setDisciplinaArte($disciplinaArte)
    {
        $this->disciplinaArte = $disciplinaArte;

        return $this;
    }

    /**
     * Get disciplinaArte
     *
     * @return boolean
     */
    public function getDisciplinaArte()
    {
        return $this->disciplinaArte;
    }

    /**
     * Set realizacao
     *
     * @param \App\Entity\Realizacao $realizacao
     * @return Projeto
     */
    public function setRealizacao(\App\Entity\Realizacao $realizacao = null)
    {
        $this->realizacao = $realizacao;

        return $this;
    }

    /**
     * Get realizacao
     *
     * @return \App\Entity\Realizacao
     */
    public function getRealizacao()
    {
        return $this->realizacao;
    }

    /**
     * Add direcao
     *
     * @param \App\Entity\User $direcao
     * @return Projeto
     */
    public function addDirecao(\App\Entity\User $direcao)
    {
        $this->direcao[] = $direcao;

        return $this;
    }

    /**
     * Remove direcao
     *
     * @param \App\Entity\User $direcao
     */
    public function removeDirecao(\App\Entity\User $direcao)
    {
        $this->direcao->removeElement($direcao);
    }

    /**
     * Get direcao
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirecao()
    {
        return $this->direcao;
    }

    /**
     * Add producao
     *
     * @param \App\Entity\User $producao
     * @return Projeto
     */
    public function addProducao(\App\Entity\User $producao)
    {
        $this->producao[] = $producao;

        return $this;
    }

    /**
     * Remove producao
     *
     * @param \App\Entity\User $producao
     */
    public function removeProducao(\App\Entity\User $producao)
    {
        $this->producao->removeElement($producao);
    }

    /**
     * Get producao
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducao()
    {
        return $this->producao;
    }

    /**
     * Add fotografia
     *
     * @param \App\Entity\User $fotografia
     * @return Projeto
     */
    public function addFotografium(\App\Entity\User $fotografia)
    {
        $this->fotografia[] = $fotografia;

        return $this;
    }

    /**
     * Remove fotografia
     *
     * @param \App\Entity\User $fotografia
     */
    public function removeFotografium(\App\Entity\User $fotografia)
    {
        $this->fotografia->removeElement($fotografia);
    }

    /**
     * Get fotografia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * Add som
     *
     * @param \App\Entity\User $som
     * @return Projeto
     */
    public function addSom(\App\Entity\User $som)
    {
        $this->som[] = $som;

        return $this;
    }

    /**
     * Remove som
     *
     * @param \App\Entity\User $som
     */
    public function removeSom(\App\Entity\User $som)
    {
        $this->som->removeElement($som);
    }

    /**
     * Get som
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSom()
    {
        return $this->som;
    }

    /**
     * Add arte
     *
     * @param \App\Entity\User $arte
     * @return Projeto
     */
    public function addArte(\App\Entity\User $arte)
    {
        $this->arte[] = $arte;

        return $this;
    }

    /**
     * Remove arte
     *
     * @param \App\Entity\User $arte
     */
    public function removeArte(\App\Entity\User $arte)
    {
        $this->arte->removeElement($arte);
    }

    /**
     * Get arte
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArte()
    {
        return $this->arte;
    }

    /**
     * Set copiaFinal
     *
     * @param \App\Entity\CopiaFinal $copiaFinal
     * @return Projeto
     */
    public function setCopiaFinal(\App\Entity\CopiaFinal $copiaFinal = null)
    {
        $this->copiaFinal = $copiaFinal;

        return $this;
    }

    /**
     * Get copiaFinal
     *
     * @return \App\Entity\CopiaFinal
     */
    public function getCopiaFinal()
    {
        return $this->copiaFinal;
    }

    /**
     * Add historicos
     *
     * @param \App\Entity\ProjetoHistorico $historicos
     * @return Projeto
     */
    public function addHistorico(\App\Entity\ProjetoHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\ProjetoHistorico $historicos
     */
    public function removeHistorico(\App\Entity\ProjetoHistorico $historicos)
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
