<?php

namespace App\Repository;

use App\Repository\AbstractCrudRepository;

class FuncaoRepository extends AbstractCrudRepository
{
    public function getFuncaoFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.nome', 'ASC')
        ;
    }
}
