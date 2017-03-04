<?php

namespace Cinevi\SecurityBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cinevi\SecurityBundle\Entity\UserRepository")
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     **/
    protected $telefone;

    /**
     * @ORM\Column(type="integer")
     **/
    protected $matricula;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $confirmado;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $professor;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $breveCurriculo;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set telefone
     *
     * @param integer $telefone
     * @return User
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return integer
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set matricula
     *
     * @param integer $matricula
     * @return User
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return integer
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     * @return User
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }


    /**
    * @ORM\PrePersist
    */
    public function setTelefoneValue()
    {
        if(!$this->getTelefone()) {
            $this->telefone = 0;
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function setMatriculaValue()
    {
        if(!$this->getMatricula()) {
            $this->matricula = 0;
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function setConfirmadoValue()
    {
        if(!$this->getConfirmado()) {
            $this->confirmado = false;
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function setProfessorValue()
    {
        if(!$this->getProfessor()) {
            $this->professor = false;
        }
    }

    /**
     * Set professor
     *
     * @param integer $professor
     * @return User
     */
    public function setProfessor($professor)
    {
        $this->professor = $professor;

        return $this;
    }

    /**
     * Get professor
     *
     * @return integer
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * Set breveCurriculo
     *
     * @param string $breveCurriculo
     * @return User
     */
    public function setBreveCurriculo($breveCurriculo)
    {
        $this->breveCurriculo = $breveCurriculo;

        return $this;
    }

    /**
     * Get breveCurriculo
     *
     * @return string
     */
    public function getBreveCurriculo()
    {
        return $this->breveCurriculo;
    }
}
