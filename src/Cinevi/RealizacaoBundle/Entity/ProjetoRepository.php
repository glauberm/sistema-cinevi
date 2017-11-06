<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Cinevi\AdminBundle\Entity\CrudRepository;

class ProjetoRepository extends CrudRepository
{
    public function list($builderName = 'item')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->join('item.realizacao', 'r')
            ->leftJoin('r.user', 'u')
            ->orderBy($builderName.'.id', 'DESC')
        ;
    }
}
