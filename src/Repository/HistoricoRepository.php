<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Historico;

class HistoricoRepository extends EntityRepository
{
    public function buildHistorico($data, TokenStorageInterface $tokenStorageInterface)
    {
        $historico = new Historico();

        $historico->setUser($tokenStorageInterface->getToken()->getUser());
        $historico->setCreatedIn(new \DateTime());
        $historico->setData($data);

        return $historico;
    }
}
