<?php

namespace RealizacaoBundle\Entity;

use AdminBundle\Entity\AbstractCrudRepository;

class ProjetoRepository extends AbstractCrudRepository
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

    public function getProjetoFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->innerJoin($builderName.'.realizacao', $builderName.'_realizacao')
            ->orderBy($builderName.'_realizacao.titulo', 'ASC')
        ;
    }

    public function getAuthorizedProjetoFieldQB($authorizationChecker, $builderName = 'item')
    {
        $qb = $this->getProjetoFieldQB($builderName);

        foreach ($qb->getQuery()->getResult() as $result) {
            if (false === $authorizationChecker->isGranted('edit', $result)) {
                $qb->andWhere($builderName.'.id != '.$result->getId());
            }
        }

        return $qb;
    }
}
