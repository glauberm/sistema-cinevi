<?php

namespace App\Repository;

class UserRepository extends AbstractCrudRepository
{
    public function getUserFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->where($builderName.'.id != 1')
            ->orderBy($builderName.'.username', 'ASC')
        ;
    }

    public function getAuthorizedUserFieldQB($authorizationChecker, $builderName = 'item')
    {
        $qb = $this->getUserFieldQB($builderName);

        foreach ($qb->getQuery()->getResult() as $result) {
            if (false === $authorizationChecker->isGranted('edit', $result)) {
                $qb->andWhere($builderName.'.id != '.$result->getId());
            }
        }

        return $qb;
    }

    public function getProfessorFieldQB($builderName = 'item')
    {
        return $this->getUserFieldQB($builderName)
            ->where($builderName.'.professor = 1')
        ;
    }

    protected function filterValues($values)
    {
        unset($values['usernameCanonical']);
        unset($values['emailCanonical']);
        unset($values['salt']);
        unset($values['password']);
        unset($values['lastLogin']);
        unset($values['confirmationToken']);
        unset($values['passwordRequestedAt']);
        unset($values['roles']);

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        return array(
            'username' => 'Nome',
            'email' => 'Email',
            'enabled' => 'Ativo?',
            'telefone' => 'Telefone',
            'matricula' => 'Matrícula',
            'professor' => 'Professor?',
            'breveCurriculo' => 'Breve Currículo',
            'confirmado' => 'Confirmado?',
            'createdIn' => 'Data e hora desta versão',
            'autor_id' => 'Autor desta versão',
        );
    }
}
