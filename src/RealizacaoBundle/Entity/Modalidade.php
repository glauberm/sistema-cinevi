<?php

namespace RealizacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="RealizacaoBundle\Entity\ModalidadeRepository")
 * @ORM\Table(name="realizacao_modalidades")
 * @ORM\HasLifecycleCallbacks()
 */
class Modalidade
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
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $descricao;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $createdIn;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $updatedIn;


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
     * @return Modalidade
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
     * Set descricao
     *
     * @param string $descricao
     * @return Modalidade
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set createdIn
     *
     * @param \DateTime $createdIn
     *
     * @return Modalidade
     */
    public function setCreatedIn($createdIn)
    {
        $this->createdIn = $createdIn;

        return $this;
    }

    /**
     * Get createdIn
     *
     * @return \DateTime
     */
    public function getCreatedIn()
    {
        return $this->createdIn;
    }

    /**
     * Set updatedIn
     *
     * @param \DateTime $updatedIn
     *
     * @return Modalidade
     */
    public function setUpdatedIn($updatedIn)
    {
        $this->updatedIn = $updatedIn;

        return $this;
    }

    /**
     * Get updatedIn
     *
     * @return \DateTime
     */
    public function getUpdatedIn()
    {
        return $this->updatedIn;
    }

    /**
    * @ORM\PrePersist
    */
    public function setCreatedInValue()
    {
        $this->createdIn = new \DateTime();
    }

    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function setUpdatedInValue()
    {
        $this->updatedIn = new \DateTime();
    }
}
