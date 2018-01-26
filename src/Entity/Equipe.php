<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipeRepository")
 * @ORM\Table(name="realizacao_equipes")
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Funcao", cascade={"merge"}, inversedBy="equipes")
     **/
    protected $funcao;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"merge"})
     **/
    protected $users;


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
     * Set funcao
     *
     * @param \App\Entity\Funcao $funcao
     * @return Equipe
     */
    public function setFuncao(\App\Entity\Funcao $funcao = null)
    {
        $this->funcao = $funcao;

        return $this;
    }

    /**
     * Get funcao
     *
     * @return \App\Entity\Funcao
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * Add users
     *
     * @param \App\Entity\User $users
     * @return Equipe
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
}
