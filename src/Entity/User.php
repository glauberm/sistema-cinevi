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
     * @ORM\Column(type="datetime")
     **/
    protected $createdIn;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $updatedIn;


    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->realizacaos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set createdIn
     *
     * @param \DateTime $createdIn
     *
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
     * Set updatedIn
     *
     * @param \DateTime $updatedIn
     *
     * @return User
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
