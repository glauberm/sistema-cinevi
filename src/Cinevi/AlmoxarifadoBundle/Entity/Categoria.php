<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="almoxarifado_equipamentos_categorias")
 */
class Categoria
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     **/
    protected $nome;

    /**
     * @ORM\OneToMany(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Equipamento", cascade={"merge"}, mappedBy="categoria")
     **/
    protected $equipamentos;

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
     * Set nome
     *
     * @param string $nome
     * @return Categoria
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add equipamentos
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos
     * @return Categoria
     */
    public function addEquipamento(\Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos[] = $equipamentos;

        return $this;
    }

    /**
     * Remove equipamentos
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos
     */
    public function removeEquipamento(\Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos->removeElement($equipamentos);
    }

    /**
     * Get equipamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipamentos()
    {
        return $this->equipamentos;
    }
}
