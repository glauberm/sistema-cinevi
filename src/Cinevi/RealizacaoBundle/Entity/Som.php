<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realizacao_projeto_equipes_som")
 */
class Som extends Equipe
{
    /**
     * @ORM\Column(type="boolean")
     **/
    protected $disciplina;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set disciplina
     *
     * @param boolean $disciplina
     * @return Som
     */
    public function setDisciplina($disciplina)
    {
        $this->disciplina = $disciplina;

        return $this;
    }

    /**
     * Get disciplina
     *
     * @return boolean
     */
    public function getDisciplina()
    {
        return $this->disciplina;
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
     * Set breveCurriculo
     *
     * @param string $breveCurriculo
     * @return Som
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
     * Add users
     *
     * @param \Cinevi\SecurityBundle\Entity\User $users
     * @return Som
     */
    public function addUser(\Cinevi\SecurityBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Cinevi\SecurityBundle\Entity\User $users
     */
    public function removeUser(\Cinevi\SecurityBundle\Entity\User $users)
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
}
