<?php
namespace Cinevi\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="configurations")
 */
class Configuration
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $reservasFechadas;



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
     * Set reservasFechadas
     *
     * @param boolean $reservasFechadas
     * @return Configuration
     */
    public function setReservasFechadas($reservasFechadas)
    {
        $this->reservasFechadas = $reservasFechadas;

        return $this;
    }

    /**
     * Get reservasFechadas
     *
     * @return boolean 
     */
    public function getReservasFechadas()
    {
        return $this->reservasFechadas;
    }
}
