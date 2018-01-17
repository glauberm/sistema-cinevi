<?php

namespace App\Repository;

use App\Repository\AbstractCrudRepository;

class EquipamentoRepository extends AbstractCrudRepository
{
    public function list($authorizationChecker, $builderName = 'item')
    {
        $qb = parent::list($authorizationChecker, $builderName);

        return $qb->innerJoin($builderName.'.categoria', $builderName.'_categoria');
    }

    public function listWhereCategoriaIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->where($builderName.'.categoria = :id')
            ->setParameter('id', $id)
        ;
    }

    public function listWhereReservaIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->innerJoin($builderName.'.calendarEvents', $builderName.'_calendarEvents')
            ->where($builderName.'_calendarEvents.id = :id')
            ->setParameter('id', $id)
        ;
    }

    public function getEquipamentoFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.codigo', 'ASC')
            ->where($builderName.'.manutencao != 1')
        ;
    }

    public function getAuthorizedEquipamentoFieldQB($tokenStorageInterface, $authorizationChecker, $builderName = 'item')
    {
        $qb = $this->getEquipamentoFieldQB($builderName);

        foreach ($qb->getQuery()->getResult() as $result) {
            //if (!$result->getUsers()->isEmpty()) {
                foreach ($result->getUsers() as $user) {
                    if ($user !== $tokenStorageInterface->getToken()->getUser() || !$authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
                        $qb->andWhere($builderName.'.id != '.$result->getId());
                    }
                }
            //}
        }

        return $qb;
    }
}
