<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Base
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"merge"})
     **/
    protected $autor;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $createdIn;


    /**
     * Set autor
     *
     * @param \App\Entity\User $autor
     * @return Base
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
     * @return Base
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
}
