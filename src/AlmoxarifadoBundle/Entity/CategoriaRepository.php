<?php

namespace AlmoxarifadoBundle\Entity;

use AdminBundle\Entity\AbstractCrudRepository;

class CategoriaRepository extends AbstractCrudRepository
{
    public function getCategoriaFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.nome', 'ASC')
        ;
    }
}
