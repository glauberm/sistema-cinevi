<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Historico
{
    /**
     * @ORM\Column(type="integer")
     **/
    protected $versao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $createdIn;

    /**
     * @ORM\Column(type="array")
     **/
    protected $data;


    /**
     * Set versao
     *
     * @param integer $versao
     * @return Historico
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;

        return $this;
    }

    /**
     * Get versao
     *
     * @return integer
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     * @return Historico
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdIn
     *
     * @param \DateTime $createdIn
     * @return Historico
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
     * Set data
     *
     * @param array $data
     * @return Historico
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
