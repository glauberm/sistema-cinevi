<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class HistoricoRepository extends EntityRepository
{
    public function buildHistorico($obj, $data, $historico, TokenStorageInterface $tokenStorageInterface)
    {
        $historico->setObj($obj);
        $historico->setVersao($obj->getHistoricos()->count()+1);
        $historico->setUser($tokenStorageInterface->getToken()->getUser());
        $historico->setCreatedIn(new \DateTime());
        $historico->setData($data[0]);

        return $historico;
    }

    public function list($obj, $builderName = 'historico')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->where($builderName.'.obj = '.$obj->getId())
            ->orderBy($builderName.'.versao', 'DESC')
        ;
    }

    /*private function transformData(array $data)
    {
        $keys =
    }*/
}
