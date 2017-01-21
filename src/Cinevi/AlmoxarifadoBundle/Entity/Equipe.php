<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
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
     * @ORM\ManyToMany(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $users;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $breveCurriculo;

}
