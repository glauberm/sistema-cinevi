<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

abstract class AbstractCrudRepository extends EntityRepository
{
    public function list($authorizationChecker, $builderName = 'item')
    {
        $qb = $this->createQueryBuilder($builderName);

        foreach ($qb->getQuery()->getResult() as $result) {
            if (false === $authorizationChecker->isGranted('view', $result)) {
                $qb->andWhere($builderName.'.id != '.$result->getId());
            }
        }

        return $qb->orderBy($builderName.'.id', 'DESC');
    }

    public function getCsv($qb)
    {
        return $qb
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
        ;
    }
}
