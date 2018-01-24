<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoricoRepository")
 * @ORM\Table(name="historico_funcoes")
 */
class FuncaoHistorico extends Historico
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Funcao", cascade={"merge"})
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
     * @param \App\Entity\Funcao $obj
     * @return FuncaoHistorico
     */
    public function setObj(\App\Entity\Funcao $obj = null)
    {
        $this->obj = $obj;

        return $this;
    }

    /**
     * Get obj
     *
     * @return \App\Entity\Funcao
     */
    public function getObj()
    {
        return $this->obj;
    }
}
