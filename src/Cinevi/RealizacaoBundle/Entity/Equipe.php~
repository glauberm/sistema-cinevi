<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realizacao_equipes")
 */
abstract class Equipe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Funcao", cascade={"merge"})
     **/
    protected $funcao;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
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
     * @param \Cinevi\RealizacaoBundle\Entity\Funcao $funcao
     * @return Equipe
     */
    public function setFuncao(\Cinevi\RealizacaoBundle\Entity\Funcao $funcao = null)
    {
        $this->funcao = $funcao;

        return $this;
    }

    /**
     * Get funcao
     *
     * @return \Cinevi\RealizacaoBundle\Entity\Funcao 
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * Add users
     *
     * @param \Cinevi\SecurityBundle\Entity\User $users
     * @return Equipe
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
