<?php

namespace RealizacaoBundle\Entity;

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
     * @ORM\ManyToMany(targetEntity="RealizacaoBundle\Entity\Equipe", cascade={"all"}, orphanRemoval=true)
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


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set elenco
     *
     * @param string $elenco
     * @return FichaTecnica
     */
    public function setElenco($elenco)
    {
        $this->elenco = $elenco;

        return $this;
    }

    /**
     * Get elenco
     *
     * @return string
     */
    public function getElenco()
    {
        return $this->elenco;
    }

    /**
     * Set outrasInformacoes
     *
     * @param string $outrasInformacoes
     * @return FichaTecnica
     */
    public function setOutrasInformacoes($outrasInformacoes)
    {
        $this->outrasInformacoes = $outrasInformacoes;

        return $this;
    }

    /**
     * Get outrasInformacoes
     *
     * @return string
     */
    public function getOutrasInformacoes()
    {
        return $this->outrasInformacoes;
    }

    /**
     * Set festivais
     *
     * @param string $festivais
     * @return FichaTecnica
     */
    public function setFestivais($festivais)
    {
        $this->festivais = $festivais;

        return $this;
    }

    /**
     * Get festivais
     *
     * @return string
     */
    public function getFestivais()
    {
        return $this->festivais;
    }

    /**
     * Set premios
     *
     * @param string $premios
     * @return FichaTecnica
     */
    public function setPremios($premios)
    {
        $this->premios = $premios;

        return $this;
    }

    /**
     * Get premios
     *
     * @return string
     */
    public function getPremios()
    {
        return $this->premios;
    }

    /**
     * Add equipes
     *
     * @param \RealizacaoBundle\Entity\Equipe $equipes
     * @return FichaTecnica
     */
    public function addEquipe(\RealizacaoBundle\Entity\Equipe $equipes)
    {
        $this->equipes[] = $equipes;

        return $this;
    }

    /**
     * Remove equipes
     *
     * @param \RealizacaoBundle\Entity\Equipe $equipes
     */
    public function removeEquipe(\RealizacaoBundle\Entity\Equipe $equipes)
    {
        $this->equipes->removeElement($equipes);
    }

    /**
     * Get equipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipes()
    {
        return $this->equipes;
    }
}
