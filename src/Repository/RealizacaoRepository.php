<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Modalidade;

class RealizacaoRepository extends AbstractEntityRepository
{
    protected function filterValues($values)
    {
        $user = $this->getEntityManager()
            ->getRepository(User::class)->find($values['user_id'])
        ;
        $values['user_id'] = $user->getUsername();

        if($values['modalidade_id']) {
            $modalidade = $this->getEntityManager()
                ->getRepository(Modalidade::class)->find($values['modalidade_id'])
            ;
            $values['modalidade_id'] = $modalidade->getNome();
        }

        if($values['professor_id']) {
            $professor = $this->getEntityManager()
                ->getRepository(User::class)->find($values['professor_id'])
            ;
            $values['professor_id'] = $professor->getUsername();
        }

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        return array(
            'titulo' => 'Título',
            'sinopse' => 'Sinopse',
            'genero' => 'Gênero(s)',
            'locacoes' => 'Locação(ões)',
            'captacao' => 'Captação',
            'detalhesCaptacao' => 'Detalhes da Captação',
            'user_id' => 'Usuário',
            'modalidade_id' => 'Modalidade',
            'professor_id' => 'Professor(a)',
            'createdIn' => 'Data e hora desta versão',
            'autor_id' => 'Autor(a) desta versão',
        );
    }
}
