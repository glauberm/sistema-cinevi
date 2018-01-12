<?php

namespace AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AlmoxarifadoBundle\Entity\EquipamentoRepository")
 * @ORM\Table(name="almoxarifado_equipamentos")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\ManyToOne(targetEntity="AlmoxarifadoBundle\Entity\Categoria", cascade={"merge"}, inversedBy="equipamentos")
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
     * @ORM\Column(type="string", nullable=true, unique=true)
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
     * @ORM\Column(type="boolean")
     **/
    protected $atrasado;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", cascade={"merge"})
     **/
    protected $users;

    /**
     * @ORM\ManyToMany(targetEntity="AlmoxarifadoBundle\Entity\CalendarEvent", cascade={"merge"}, mappedBy="equipamentos")
     **/
    protected $calendarEvents;

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
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get nome
     *
     * @return string
     */
    public function getCodigoAndNome()
    {
        return '['.$this->getCodigo().'] '.$this->getNome();
    }

    /**
     * Set patrimonio
     *
     * @param string $patrimonio
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
     * @return string
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
     * @param \AlmoxarifadoBundle\Entity\Categoria $categoria
     * @return Equipamento
     */
    public function setCategoria(\AlmoxarifadoBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AlmoxarifadoBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getCategoriaByNome()
    {
        return $this->getCategoria()->getNome();
    }

    /**
     * Add users
     *
     * @param \UserBundle\Entity\User $users
     * @return Equipamento
     */
    public function addUser(\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \UserBundle\Entity\User $users
     */
    public function removeUser(\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add calendarEvents
     *
     * @param \AlmoxarifadoBundle\Entity\CalendarEvent $calendarEvents
     * @return Equipamento
     */
    public function addCalendarEvent(\AlmoxarifadoBundle\Entity\CalendarEvent $calendarEvents)
    {
        $this->calendarEvents[] = $calendarEvents;

        return $this;
    }

    /**
     * Remove calendarEvents
     *
     * @param \AlmoxarifadoBundle\Entity\CalendarEvent $calendarEvents
     */
    public function removeCalendarEvent(\AlmoxarifadoBundle\Entity\CalendarEvent $calendarEvents)
    {
        $this->calendarEvents->removeElement($calendarEvents);
    }

    /**
     * Get calendarEvents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendarEvents()
    {
        return $this->calendarEvents;
    }

    /**
     * Set atrasado
     *
     * @param boolean $atrasado
     * @return Equipamento
     */
    public function setAtrasado($atrasado)
    {
        $this->atrasado = $atrasado;

        return $this;
    }

    /**
     * Get atrasado
     *
     * @return boolean
     */
    public function getAtrasado()
    {
        return $this->atrasado;
    }

    /**
     * Set createdIn
     *
     * @param \DateTime $createdIn
     *
     * @return Equipamento
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
     * @return Equipamento
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