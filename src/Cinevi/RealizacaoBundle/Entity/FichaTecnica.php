<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realizacao_copia_final_ficha_tecnica")
 */
class FichaTecnica
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\RealizacaoBundle\Entity\Equipe", cascade={"all"})
     **/
    protected $equipes;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $elenco;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $outrasInformacoes;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $festivais;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $premios;


}
