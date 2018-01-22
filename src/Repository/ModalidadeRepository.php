<?php

namespace App\Repository;

class ModalidadeRepository extends AbstractCrudRepository
{
    public function getModalidadeFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.nome', 'ASC')
        ;
    }
}
