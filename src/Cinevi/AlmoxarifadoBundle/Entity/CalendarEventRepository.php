<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Cinevi\AdminBundle\Entity\CrudRepository;

class CalendarEventRepository extends CrudRepository
{
    public function findAllBetweenDates($startDate, $endDate, $builderName = 'item')
    {
        $qb = $this->createQueryBuilder($builderName);

        $reservas = $qb
            ->where($qb->expr()->andX(
                $qb->expr()->lte($builderName.'.startDate', ':startDate'),
                $qb->expr()->gte($builderName.'.endDate', ':endDate')
            ))
            ->orWhere($qb->expr()->andX(
                $qb->expr()->gte($builderName.'.endDate', ':startDate'),
                $qb->expr()->lte($builderName.'.startDate', ':endDate')
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
            ->innerJoin($builderName.'.equipamentos', $builderName.'e')
            ->where($builderName.'e.id = :id')
            ->setParameter('id', $id)
        ;
    }
}
