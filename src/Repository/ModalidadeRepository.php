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

    protected function getReplaceArrayKeys()
    {
        return array(
            'nome' => 'Nome',
            'descricao' => 'Descrição',
        );
    }
}
