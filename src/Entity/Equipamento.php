<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipamentoRepository")
 * @ORM\Table(name="almoxarifado_equipamentos")
 */
class Equipamento extends Base
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", cascade={"merge"}, inversedBy="equipamentos")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"merge"})
     **/
    protected $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CalendarEvent", cascade={"merge"}, mappedBy="equipamentos")
     **/
    protected $calendarEvents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\EquipamentoHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \App\Entity\Categoria $categoria
     * @return Equipamento
     */
    public function setCategoria(\App\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \App\Entity\Categoria
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
        if($this->getCategoria()) {
            return $this->getCategoria()->getNome();
        } else {
            return 'Sem Categoria';
        }
    }

    /**
     * Add users
     *
     * @param \App\Entity\User $users
     * @return Equipamento
     */
    public function addUser(\App\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \App\Entity\User $users
     */
    public function removeUser(\App\Entity\User $users)
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
     * @param \App\Entity\CalendarEvent $calendarEvents
     * @return Equipamento
     */
    public function addCalendarEvent(\App\Entity\CalendarEvent $calendarEvents)
    {
        $this->calendarEvents[] = $calendarEvents;

        return $this;
    }

    /**
     * Remove calendarEvents
     *
     * @param \App\Entity\CalendarEvent $calendarEvents
     */
    public function removeCalendarEvent(\App\Entity\CalendarEvent $calendarEvents)
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
     * Add historicos
     *
     * @param \App\Entity\EquipamentoHistorico $historicos
     * @return Equipamento
     */
    public function addHistorico(\App\Entity\EquipamentoHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\EquipamentoHistorico $historicos
     */
    public function removeHistorico(\App\Entity\EquipamentoHistorico $historicos)
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
