<?php

namespace RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="RealizacaoBundle\Entity\Funcao", cascade={"merge"})
     **/
    protected $funcao;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", cascade={"merge"})
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
     * @param \RealizacaoBundle\Entity\Funcao $funcao
     * @return Equipe
     */
    public function setFuncao(\RealizacaoBundle\Entity\Funcao $funcao = null)
    {
        $this->funcao = $funcao;

        return $this;
    }

    /**
     * Get funcao
     *
     * @return \RealizacaoBundle\Entity\Funcao
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * Add users
     *
     * @param \UserBundle\Entity\User $users
     * @return Equipe
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
}
