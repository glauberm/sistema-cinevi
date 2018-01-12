<?php

namespace RealizacaoBundle\Entity;

use AdminBundle\Entity\AbstractCrudRepository;

class ModalidadeRepository extends AbstractCrudRepository
{
    public function getModalidadeFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.nome', 'ASC')
        ;
    }
}
