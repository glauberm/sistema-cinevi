<?php

namespace App\Repository;

abstract class AbstractCrudRepository extends AbstractEntityRepository
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

    public function getArrayResultWithKeys($qb)
    {
        $items = $this->getArrayResult($qb);
        $keys = $this->extractKeys($items);

        return array_merge($keys, $items);
    }

    public function getArrayResultByIdWithKeys($id, $className, $builderName = 'item')
    {
        $items = $this->getArrayResultById($id, $className, $builderName);
        $keys = $this->extractKeys($items);

        return array_merge($keys, $items);
    }
}
