<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractEntityRepository extends EntityRepository
{
    public function getArrayResult($qb)
    {
        $items = $qb
            ->getQuery()
            ->setHint(\Doctrine\ORM\Query::HINT_INCLUDE_META_COLUMNS, true)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
        ;

        return $this->filterArrayResult($items);
    }

    public function getArrayResultById($id, $className, $builderName = 'item')
    {
        $repository = $this->getEntityManager()->getRepository($className);
        $qb = $repository->createQueryBuilder($builderName)
            ->where($builderName.'.id = '.$id)
        ;

        return $repository->getArrayResult($qb);
    }

    protected function filterValues($values)
    {
        return $values;
    }

    protected function filterArrayResult($items)
    {
        foreach ($items as $key => $values) {
            $values = $this->filterValues($values);
            unset($values['id']);
            $items[$key] = $values;
        }

        return $items;
    }

    protected function extractKeys($items)
    {
        $keys = array();
        foreach ($items as $item) {
            $keys[0] = array_keys($item);
            $keys[0] = $this->filterKeys($keys[0]);
            break;
        }

        return $keys;
    }

    protected function filterKeys($keys)
    {
        foreach ($this->getReplaceArrayKeys() as $searchValue => $replaceValue) {
            $key = array_search($searchValue, $keys);
            $keys[$key] = mb_strtoupper($replaceValue);
        }

        return $keys;
    }

    protected function getReplaceArrayKeys()
    {
        return array();
    }
}
