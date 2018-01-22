<?php

namespace App\Repository;

use App\Entity\Funcao;
use App\Entity\User;

class EquipeRepository extends AbstractEntityRepository
{
    protected function filterValues($values)
    {
        $funcao = $this->getEntityManager()
            ->getRepository(Funcao::class)->find($values['funcao_id'])
        ;
        $values['ficha_tecnica'] = $funcao->getNome();
        unset($values['funcao_id']);

        $users = $this->find($values['id'])->getUsers();
        $usernames = array();
        foreach($users as $user) {
            $usernames[] = $user->getUsername();
        }

        $values['ficha_tecnica'] .= ': ' . implode(', ', $usernames);

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        return array(
            'ficha_tecnica' => 'Ficha Técnica',
        );
    }
}
