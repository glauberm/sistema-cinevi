<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Cinevi\AdminBundle\Entity\CrudRepository;

class EquipamentoRepository extends CrudRepository
{
    public function list($builderName = 'item')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->join($builderName.'.categoria', 'c')
            ->orderBy($builderName.'.id', 'DESC')
        ;
    }
}
