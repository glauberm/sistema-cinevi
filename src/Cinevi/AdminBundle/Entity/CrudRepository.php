<?php

namespace Cinevi\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

abstract class CrudRepository extends EntityRepository
{
    public function list($builderName = 'item')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->orderBy($builderName.'.id', 'DESC')
        ;
    }

    public function getCsv($qb)
    {
        return $qb
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
        ;
    }
}
