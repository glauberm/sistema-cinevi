<?php

namespace App\Repository;

use App\Repository\AbstractCrudRepository;

class CalendarEventRepository extends AbstractCrudRepository
{
    public function findAllBetweenDates($startDate, $endDate, $builderName = 'item')
    {
        $qb = $this->createQueryBuilder($builderName);

        $reservas = $qb
            ->where($qb->expr()->andX(
                $qb->expr()->lt($builderName.'.startDate', ':startDate'),
                $qb->expr()->gt($builderName.'.endDate', ':endDate')
            ))
            ->orWhere($qb->expr()->andX(
                $qb->expr()->gt($builderName.'.endDate', ':startDate'),
                $qb->expr()->lt($builderName.'.startDate', ':endDate')
            ))
            ->orWhere($qb->expr()->andX(
                $qb->expr()->eq($builderName.'.startDate', ':startDate'),
                $qb->expr()->eq($builderName.'.endDate', ':startDate')
            ))
            ->setParameter('startDate', $startDate, \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('endDate', $endDate, \Doctrine\DBAL\Types\Type::DATETIME)
        ;

        return $reservas;
    }

    public function findAllBetweenDatesButId($startDate, $endDate, $id, $builderName = 'item')
    {
        $reservas = $this->findAllBetweenDates($startDate, $endDate, $builderName);

        $reservas = $reservas
            ->andWhere($builderName.'.id != (:id)')
            ->setParameter('id', $id)
        ;

        return $reservas;
    }

    public function listWhereUserIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->where($builderName.'.user = :id')
            ->setParameter('id', $id)
        ;
    }

    public function listWhereEquipamentoIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->innerJoin($builderName.'.equipamentos', $builderName.'_equipamentos')
            ->where($builderName.'_equipamentos.id = :id')
            ->setParameter('id', $id)
        ;
    }
}
