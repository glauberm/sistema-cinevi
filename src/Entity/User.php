<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
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
    protected $telefone;

    /**
     * @ORM\Column(type="string")
     **/
    protected $matricula;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $confirmado = 0;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $professor = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $breveCurriculo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Realizacao", cascade={"merge", "remove"}, mappedBy="user")
     **/
    protected $realizacaos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CalendarEvent", cascade={"merge", "remove"}, mappedBy="user")
     **/
    protected $calendarEvents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Projeto", cascade={"merge"}, mappedBy="direcao")
     **/
    protected $direcaoProjetos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Projeto", cascade={"merge"}, mappedBy="producao")
     **/
    protected $producaoProjetos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Projeto", cascade={"merge"}, mappedBy="fotografia")
     **/
    protected $fotografiaProjetos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Projeto", cascade={"merge"}, mappedBy="som")
     **/
    protected $somProjetos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Projeto", cascade={"merge"}, mappedBy="arte")
     **/
    protected $arteProjetos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"merge"})
     **/
    protected $autor;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $createdIn;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    public function __construct()
    {
        parent::__construct();
        $this->realizacaos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calendarEvents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->direcaoProjetos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->producaoProjetos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fotografiaProjetos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->somProjetos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->arteProjetos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return User
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     * @return User
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     * @return User
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * Set professor
     *
     * @param boolean $professor
     * @return User
     */
    public function setProfessor($professor)
    {
        $this->professor = $professor;

        return $this;
    }

    /**
     * Get professor
     *
     * @return boolean
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * Set breveCurriculo
     *
     * @param string $breveCurriculo
     * @return User
     */
    public function setBreveCurriculo($breveCurriculo)
    {
        $this->breveCurriculo = $breveCurriculo;

        return $this;
    }

    /**
     * Get breveCurriculo
     *
     * @return string
     */
    public function getBreveCurriculo()
    {
        return $this->breveCurriculo;
    }

    /**
     * Add realizacaos
     *
     * @param \App\Entity\Realizacao $realizacaos
     * @return User
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
     * Add calendarEvents
     *
     * @param \App\Entity\CalendarEvent $calendarEvents
     * @return User
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
     * Set autor
     *
     * @param \App\Entity\User $autor
     * @return User
     */
    public function setAutor(\App\Entity\User $autor = null)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return \App\Entity\User
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set createdIn
     *
     * @param \DateTime $createdIn
     * @return User
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
     * Add historicos
     *
     * @param \App\Entity\UserHistorico $historicos
     * @return User
     */
    public function addHistorico(\App\Entity\UserHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\UserHistorico $historicos
     */
    public function removeHistorico(\App\Entity\UserHistorico $historicos)
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

    /**
     * Add direcaoProjetos
     *
     * @param \App\Entity\Projeto $direcaoProjetos
     * @return User
     */
    public function addDirecaoProjeto(\App\Entity\Projeto $direcaoProjetos)
    {
        $this->$direcaoProjetos[] = $$direcaoProjetos;

        return $this;
    }

    /**
     * Remove direcaoProjetos
     *
     * @param \App\Entity\Projeto $direcaoProjetos
     */
    public function removeDirecaoProjeto(\App\Entity\Projeto $direcaoProjetos)
    {
        $this->direcaoProjetos->removeElement($direcaoProjetos);
    }

    /**
     * Get direcaoProjetos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirecaoProjetos()
    {
        return $this->direcaoProjetos;
    }

    /**
     * Add producaoProjetos
     *
     * @param \App\Entity\Projeto $producaoProjetos
     * @return User
     */
    public function addProducaoProjeto(\App\Entity\Projeto $producaoProjetos)
    {
        $this->$producaoProjetos[] = $$producaoProjetos;

        return $this;
    }

    /**
     * Remove producaoProjetos
     *
     * @param \App\Entity\Projeto $producaoProjetos
     */
    public function removeProducaoProjeto(\App\Entity\Projeto $producaoProjetos)
    {
        $this->producaoProjetos->removeElement($producaoProjetos);
    }

    /**
     * Get producaoProjetos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducaoProjetos()
    {
        return $this->producaoProjetos;
    }

    /**
     * Add fotografiaProjetos
     *
     * @param \App\Entity\Projeto $fotografiaProjetos
     * @return User
     */
    public function addFotografiaProjeto(\App\Entity\Projeto $fotografiaProjetos)
    {
        $this->$fotografiaProjetos[] = $$fotografiaProjetos;

        return $this;
    }

    /**
     * Remove fotografiaProjetos
     *
     * @param \App\Entity\Projeto $fotografiaProjetos
     */
    public function removeFotografiaProjeto(\App\Entity\Projeto $fotografiaProjetos)
    {
        $this->fotografiaProjetos->removeElement($fotografiaProjetos);
    }

    /**
     * Get fotografiaProjetos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFotografiaProjetos()
    {
        return $this->fotografiaProjetos;
    }

    /**
     * Add somProjetos
     *
     * @param \App\Entity\Projeto $somProjetos
     * @return User
     */
    public function addSomProjeto(\App\Entity\Projeto $somProjetos)
    {
        $this->$somProjetos[] = $$somProjetos;

        return $this;
    }

    /**
     * Remove somProjetos
     *
     * @param \App\Entity\Projeto $somProjetos
     */
    public function removeSomProjeto(\App\Entity\Projeto $somProjetos)
    {
        $this->somProjetos->removeElement($somProjetos);
    }

    /**
     * Get somProjetos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSomProjetos()
    {
        return $this->somProjetos;
    }

    /**
     * Add arteProjetos
     *
     * @param \App\Entity\Projeto $arteProjetos
     * @return User
     */
    public function addArteProjeto(\App\Entity\Projeto $arteProjetos)
    {
        $this->$arteProjetos[] = $$arteProjetos;

        return $this;
    }

    /**
     * Remove arteProjetos
     *
     * @param \App\Entity\Projeto $arteProjetos
     */
    public function removeArteProjeto(\App\Entity\Projeto $arteProjetos)
    {
        $this->arteProjetos->removeElement($arteProjetos);
    }

    /**
     * Get arteProjetos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArteProjetos()
    {
        return $this->arteProjetos;
    }

    /**
    * @ORM\PrePersist
    */
    public function setTelefoneValue()
    {
        if(!$this->getTelefone()) {
            $this->telefone = 0;
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function setMatriculaValue()
    {
        if(!$this->getMatricula()) {
            $this->matricula = 0;
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function setConfirmadoValue()
    {
        if(!$this->getConfirmado()) {
            $this->confirmado = false;
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function setProfessorValue()
    {
        if(!$this->getProfessor()) {
            $this->professor = false;
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function setCreatedInValue()
    {
        if(!$this->getCreatedIn()) {
            $this->createdIn = new \DateTime();
        }
    }
}
