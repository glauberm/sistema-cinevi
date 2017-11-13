<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cinevi\RealizacaoBundle\Entity\ProjetoRepository")
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
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Realizacao", cascade={"all"}, inversedBy="projeto")
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
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_direcao")
     **/
    protected $direcao;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_producao")
     **/
    protected $producao;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_fotografia")
     **/
    protected $fotografia;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $disciplinaFotografia;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     * @ORM\JoinTable(name="realizacao_projetos_som")
     **/
    protected $som;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $disciplinaSom;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
      * @ORM\JoinTable(name="realizacao_projetos_arte")
     **/
    protected $arte;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $disciplinaArte;

    /**
     * @ORM\OneToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\CopiaFinal", cascade={"merge", "remove"}, mappedBy="projeto")
     **/
    protected $copiaFinal;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $createdIn;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $updatedIn;


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
     * @param \Cinevi\RealizacaoBundle\Entity\Realizacao $realizacao
     * @return Projeto
     */
    public function setRealizacao(\Cinevi\RealizacaoBundle\Entity\Realizacao $realizacao = null)
    {
        $this->realizacao = $realizacao;

        return $this;
    }

    /**
     * Get realizacao
     *
     * @return \Cinevi\RealizacaoBundle\Entity\Realizacao
     */
    public function getRealizacao()
    {
        return $this->realizacao;
    }

    /**
     * Add direcao
     *
     * @param \Cinevi\SecurityBundle\Entity\User $direcao
     * @return Projeto
     */
    public function addDirecao(\Cinevi\SecurityBundle\Entity\User $direcao)
    {
        $this->direcao[] = $direcao;

        return $this;
    }

    /**
     * Remove direcao
     *
     * @param \Cinevi\SecurityBundle\Entity\User $direcao
     */
    public function removeDirecao(\Cinevi\SecurityBundle\Entity\User $direcao)
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
     * @param \Cinevi\SecurityBundle\Entity\User $producao
     * @return Projeto
     */
    public function addProducao(\Cinevi\SecurityBundle\Entity\User $producao)
    {
        $this->producao[] = $producao;

        return $this;
    }

    /**
     * Remove producao
     *
     * @param \Cinevi\SecurityBundle\Entity\User $producao
     */
    public function removeProducao(\Cinevi\SecurityBundle\Entity\User $producao)
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
     * @param \Cinevi\SecurityBundle\Entity\User $fotografia
     * @return Projeto
     */
    public function addFotografium(\Cinevi\SecurityBundle\Entity\User $fotografia)
    {
        $this->fotografia[] = $fotografia;

        return $this;
    }

    /**
     * Remove fotografia
     *
     * @param \Cinevi\SecurityBundle\Entity\User $fotografia
     */
    public function removeFotografium(\Cinevi\SecurityBundle\Entity\User $fotografia)
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
     * @param \Cinevi\SecurityBundle\Entity\User $som
     * @return Projeto
     */
    public function addSom(\Cinevi\SecurityBundle\Entity\User $som)
    {
        $this->som[] = $som;

        return $this;
    }

    /**
     * Remove som
     *
     * @param \Cinevi\SecurityBundle\Entity\User $som
     */
    public function removeSom(\Cinevi\SecurityBundle\Entity\User $som)
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
     * @param \Cinevi\SecurityBundle\Entity\User $arte
     * @return Projeto
     */
    public function addArte(\Cinevi\SecurityBundle\Entity\User $arte)
    {
        $this->arte[] = $arte;

        return $this;
    }

    /**
     * Remove arte
     *
     * @param \Cinevi\SecurityBundle\Entity\User $arte
     */
    public function removeArte(\Cinevi\SecurityBundle\Entity\User $arte)
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
     * @param \Cinevi\RealizacaoBundle\Entity\CopiaFinal $copiaFinal
     * @return Projeto
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
     * Set createdIn
     *
     * @param \DateTime $createdIn
     *
     * @return Projeto
     */
    public function setCreatedIn($createdIn)
    {
        $this->createdIn = $createdIn;

        return $this;
    }

    /**
     * Get createdIn
     *
     * @return \DateTime
     */
    public function getCreatedIn()
    {
        return $this->createdIn;
    }

    /**
     * Set updatedIn
     *
     * @param \DateTime $updatedIn
     *
     * @return Projeto
     */
    public function setUpdatedIn($updatedIn)
    {
        $this->updatedIn = $updatedIn;

        return $this;
    }

    /**
     * Get updatedIn
     *
     * @return \DateTime
     */
    public function getUpdatedIn()
    {
        return $this->updatedIn;
    }

    /**
    * @ORM\PrePersist
    */
    public function setCreatedInValue()
    {
        $this->createdIn = new \DateTime();
    }

    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function setUpdatedInValue()
    {
        $this->updatedIn = new \DateTime();
    }
}
