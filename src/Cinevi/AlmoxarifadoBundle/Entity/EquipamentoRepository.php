<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Cinevi\AdminBundle\Entity\CrudRepository;

class EquipamentoRepository extends CrudRepository
{
    public function list($builderName = 'item')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->innerJoin($builderName.'.categoria', $builderName.'c')
            ->orderBy($builderName.'.id', 'DESC')
        ;
    }

    public function listWhereCategoriaIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->where($builderName.'.categoria = :id')
            ->setParameter('id', $id)
        ;
    }
}
