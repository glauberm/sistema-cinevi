<?php

namespace Cinevi\ConfigBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ConfigRepository extends EntityRepository
{
    public function getConfig() {
        return $this
            ->createQueryBuilder('config')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
