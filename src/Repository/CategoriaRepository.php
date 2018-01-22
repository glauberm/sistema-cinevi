<?php

namespace App\Repository;

class CategoriaRepository extends AbstractCrudRepository
{
    public function getCategoriaFieldQB($builderName = 'item')
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
