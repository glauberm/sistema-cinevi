<?php

namespace App\Repository;

use App\Repository\AbstractCrudRepository;

class CategoriaRepository extends AbstractCrudRepository
{
    public function getCategoriaFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.nome', 'ASC')
        ;
    }
}
