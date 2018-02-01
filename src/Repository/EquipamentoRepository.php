<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Entity\CalendarEvent;

class EquipamentoRepository extends AbstractCrudRepository
{
    public function list($authorizationChecker, $builderName = 'item')
    {
        $qb = parent::list($authorizationChecker, $builderName);

        return $qb->leftJoin($builderName.'.categoria', $builderName.'_categoria');
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
            ->leftJoin($builderName.'.calendarEvents', $builderName.'_calendarEvents')
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
            foreach ($result->getUsers() as $user) {
                if ($user !== $tokenStorageInterface->getToken()->getUser() && !$authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
                    $qb->andWhere($builderName.'.id != '.$result->getId());
                }
            }
        }

        return $qb;
    }

    protected function filterValues($values)
    {
        if($values['categoria_id']) {
            $categoria = $this->getEntityManager()
                ->getRepository(Categoria::class)->find($values['categoria_id'])
            ;
            $values['categoria_id'] = $categoria->getNome();
        }

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        return array(
            'codigo' => 'Cód.',
            'nome' => 'Nome',
            'patrimonio' => 'Nº de Patrimônio',
            'nSerie' => 'Nº de Série',
            'acessorios' => 'Acessórios',
            'obs' => 'Observações',
            'manutencao' => 'Em Manutenção?',
            'atrasado' => 'Devolução Atrasada?',
            'categoria_id' => 'Categoria',
            'createdIn' => 'Data e hora desta versão',
            'autor_id' => 'Autor(a) desta versão',
        );
    }
}
