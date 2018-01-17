<?php

namespace App\Repository;

use App\Repository\AbstractCrudRepository;

class UserRepository extends AbstractCrudRepository
{
    public function getUserFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
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
}
