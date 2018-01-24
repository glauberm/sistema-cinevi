<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Historico
{
    /**
     * @ORM\Column(type="integer")
     **/
    protected $versao;

    /**
     * @ORM\Column(type="array")
     **/
    protected $data;


    /**
     * Set versao
     *
     * @param integer $versao
     * @return Historico
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;

        return $this;
    }

    /**
     * Get versao
     *
     * @return integer
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return Historico
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
