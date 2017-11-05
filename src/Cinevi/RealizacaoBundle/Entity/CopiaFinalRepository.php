<?php

namespace Cinevi\RealizacaoBundle\Entity;

use Cinevi\AdminBundle\Entity\CrudRepository;

class CopiaFinalRepository extends CrudRepository
{
    public function list($builderName = 'item')
    {
        return $this
            ->createQueryBuilder($builderName)
            ->join($builderName.'.realizacao', 'r')
            ->orderBy($builderName.'.id', 'DESC')
        ;
    }
}
