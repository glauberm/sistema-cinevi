<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoricoRepository")
 * @ORM\Table(name="historico_projetos")
 */
class ProjetoHistorico extends Historico
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projeto", cascade={"merge"})
     **/
    protected $obj;


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
     * Set obj
     *
     * @param \App\Entity\Projeto $obj
     * @return ProjetoHistorico
     */
    public function setObj(\App\Entity\Projeto $obj = null)
    {
        $this->obj = $obj;

        return $this;
    }

    /**
     * Get obj
     *
     * @return \App\Entity\Projeto
     */
    public function getObj()
    {
        return $this->obj;
    }
}
