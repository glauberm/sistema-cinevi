<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Cinevi\AdminBundle\Entity\CrudRepository;

class ProjetoRepository extends CrudRepository
{
    public function list($builderName = 'item')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->join($builderName.'.realizacao', 'r')
            ->leftJoin('r.user', 'u')
            ->leftJoin('r.modalidade', 'm')
            ->orderBy($builderName.'.id', 'DESC')
        ;
    }
}
