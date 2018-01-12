<?php

namespace RealizacaoBundle\Entity;

use AdminBundle\Entity\AbstractCrudRepository;

class CopiaFinalRepository extends AbstractCrudRepository
{
    public function list($authorizationChecker, $builderName = 'item')
    {
        $qb = parent::list($authorizationChecker, $builderName);

        return $qb
            ->innerJoin($builderName.'.realizacao', $builderName.'_realizacao')
            ->innerJoin($builderName.'_realizacao.user', $builderName.'_user')
            ->innerJoin($builderName.'_realizacao.modalidade', $builderName.'_modalidade')
        ;
    }

    public function listWhereUserIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->where($builderName.'_realizacao.user = :id')
            ->setParameter('id', $id)
        ;
    }
}
