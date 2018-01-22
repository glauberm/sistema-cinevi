<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Projeto;
use App\Entity\Equipamento;

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

    protected function filterValues($values)
    {
        $user = $this->getEntityManager()
            ->getRepository(User::class)->find($values['user_id'])
        ;
        $values['user_id'] = $user->getUsername();

        $projeto = $this->getEntityManager()
            ->getRepository(Projeto::class)->find($values['projeto_id'])
        ;
        $values['projeto_id'] = $projeto->getRealizacao()->getTitulo();

        $equipamentosArray = array();
        $equipamentos = $this->find($values['id'])->getEquipamentos();
        foreach($equipamentos as $equipamento) {
            $equipamento = $this->getArrayResultById($equipamento->getId(), Equipamento::class, 'equipamento');
            $equipamentosArray[] = $equipamento[0];
        }

        $values['equipamentos'] = "";
        foreach ($equipamentosArray as $equipamento) {
            $values['equipamentos'] .= '['.$equipamento['codigo'].'] '.$equipamento['nome']. PHP_EOL;
        }

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        return array(
            'title' => 'Código',
            'startDate' => 'Data de Início',
            'endDate' => 'Data de Fim',
            'user_id' => 'Usuário',
            'projeto_id' => 'Projeto',
            'equipamentos' => 'Equipamentos',
        );
    }
}
