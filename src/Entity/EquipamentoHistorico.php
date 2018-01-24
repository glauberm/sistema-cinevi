<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoricoRepository")
 * @ORM\Table(name="historico_equipamentos")
 */
class EquipamentoHistorico extends Historico
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipamento", cascade={"merge"})
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
     * @param \App\Entity\Equipamento $obj
     * @return EquipamentoHistorico
     */
    public function setObj(\App\Entity\Equipamento $obj = null)
    {
        $this->obj = $obj;

        return $this;
    }

    /**
     * Get obj
     *
     * @return \App\Entity\Equipamento
     */
    public function getObj()
    {
        return $this->obj;
    }
}
