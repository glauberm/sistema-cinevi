<?php

namespace App\Repository;

class FuncaoRepository extends AbstractCrudRepository
{
    public function getFuncaoFieldQB($builderName = 'item')
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
            'createdIn' => 'Data e hora desta versão',
            'autor_id' => 'Autor desta versão',
        );
    }
}
