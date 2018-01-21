<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractCrudRepository extends EntityRepository
{
    protected $replaceArrayKeys = array();

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

    public function getArrayResult($qb)
    {
        $items = $qb
            ->getQuery()
            ->setHint(\Doctrine\ORM\Query::HINT_INCLUDE_META_COLUMNS, true)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
        ;

        $items = $this->filterArrayResult($items);
        $keys = $this->extractKeys($items);
        $items = array_merge($keys, $items);

        return $items;
    }

    protected function sanitizeValues($values)
    {
        return $values;
    }

    private function extractKeys($items)
    {
        $keys = array();
        foreach ($items as $item) {
            $keys[0] = array_keys($item);
            $keys[0] = $this->sanitizeKeys($keys[0]);
            break;
        }

        return $keys;
    }

    private function filterArrayResult($items)
    {
        foreach ($items as $key => $values) {
            unset($values['id']);
            $values = $this->sanitizeValues($values);
            $items[$key] = $values;
        }

        return $items;
    }

    private function sanitizeKeys(array $keys)
    {
        foreach ($this->replaceArrayKeys as $searchValue => $replaceValue) {
            $key = array_search($searchValue, $keys);
            $keys[$key] = $replaceValue;
        }

        return $keys;
    }
}
