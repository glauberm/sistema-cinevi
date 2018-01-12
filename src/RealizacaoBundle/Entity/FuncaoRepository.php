<?php

namespace RealizacaoBundle\Entity;

use AdminBundle\Entity\AbstractCrudRepository;

class FuncaoRepository extends AbstractCrudRepository
{
    public function getFuncaoFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.nome', 'ASC')
        ;
    }
}
