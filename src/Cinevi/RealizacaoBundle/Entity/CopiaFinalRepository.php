<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Cinevi\AdminBundle\Entity\CrudRepository;

class CopiaFinalRepository extends CrudRepository
{
    public function list($builderName = 'item')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->innerJoin($builderName.'.realizacao', $builderName.'r')
            ->innerJoin($builderName.'r.user', $builderName.'u')
            ->innerJoin($builderName.'r.modalidade', $builderName.'m')
            ->orderBy($builderName.'.id', 'DESC')
        ;
    }

    public function listWhereUserIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->where($builderName.'r.user = :id')
            ->setParameter('id', $id)
        ;
    }
}
