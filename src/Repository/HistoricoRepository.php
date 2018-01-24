<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class HistoricoRepository extends EntityRepository
{
    public function buildHistorico($obj, $data, $historico)
    {
        $historico->setObj($obj);
        $historico->setVersao($obj->getHistoricos()->count()+1);
        $historico->setData($this->transformData($data));

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

    private function transformData(array $data)
    {
        $keys = array_values($data[0]);
        $values = array_values($data[1]);

        for ($i=0; $i < count($keys); $i++) {
            $data[$keys[$i]] = $values[$i];
        }

        unset($data[0]);
        unset($data[1]);

        return $data;
    }
}
