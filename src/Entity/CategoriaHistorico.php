<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoricoRepository")
 * @ORM\Table(name="historico_categorias")
 */
class CategoriaHistorico extends Historico
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", cascade={"merge"})
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
     * @param \App\Entity\Categoria $obj
     * @return CategoriaHistorico
     */
    public function setObj(\App\Entity\Categoria $obj = null)
    {
        $this->obj = $obj;

        return $this;
    }

    /**
     * Get obj
     *
     * @return \App\Entity\Categoria
     */
    public function getObj()
    {
        return $this->obj;
    }
}
