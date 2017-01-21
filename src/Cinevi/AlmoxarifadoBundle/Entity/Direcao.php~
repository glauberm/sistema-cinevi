<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="almoxarifado_projeto_equipes_direcao")
 */
class Direcao extends Equipe
{
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
     * Set breveCurriculo
     *
     * @param string $breveCurriculo
     * @return Direcao
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
     * @return Direcao
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
