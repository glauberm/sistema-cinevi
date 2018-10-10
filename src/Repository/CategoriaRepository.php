<?php

namespace App\Repository;

use App\Entity\Equipamento;

class CategoriaRepository extends AbstractCrudRepository
{
    public function getCategoriaFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->orderBy($builderName.'.nome', 'ASC')
        ;
    }

    protected function filterValues($values)
    {
        $equipamentos = $this->find($values['id'])->getEquipamentos();
        $equipamentosLabel = array();
        foreach($equipamentos as $equipamento) {
            $equipamentosLabel[] = $equipamento->getCodigoAndNome();
        }
        $values['equipamentos'] = implode(PHP_EOL, $equipamentosLabel);

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        return array(
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'equipamentos' => 'Equipamentos',
            'createdIn' => 'Data e hora desta versão',
            'autor_id' => 'Autor desta versão',
        );
    }
}
