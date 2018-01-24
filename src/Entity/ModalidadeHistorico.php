<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoricoRepository")
 * @ORM\Table(name="historico_modalidade")
 */
class ModalidadeHistorico extends Historico
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modalidade", cascade={"merge"})
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
     * @param \App\Entity\Modalidade $obj
     * @return ModalidadeHistorico
     */
    public function setObj(\App\Entity\Modalidade $obj = null)
    {
        $this->obj = $obj;

        return $this;
    }

    /**
     * Get obj
     *
     * @return \App\Entity\Modalidade
     */
    public function getObj()
    {
        return $this->obj;
    }
}
