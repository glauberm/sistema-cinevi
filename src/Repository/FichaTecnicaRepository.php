<?php

namespace App\Repository;

use App\Entity\Equipe;

class FichaTecnicaRepository extends AbstractEntityRepository
{
    protected function filterValues($values)
    {
        $equipesArray = array();
        $equipes = $this->find($values['id'])->getEquipes();
        foreach($equipes as $equipe) {
            $equipe = $this->getArrayResultById($equipe->getId(), Equipe::class, 'equipe');
            if(!empty($equipe)) $equipesArray[] = $equipe[0];
        }

        $values['ficha_tecnica'] = "";
        foreach ($equipesArray as $equipe) {
            $values['ficha_tecnica'] .= $equipe['ficha_tecnica'] . PHP_EOL;
        }

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        $equipeArrayKeys = $this->getEntityManager()
            ->getRepository(Equipe::class)
            ->getReplaceArrayKeys()
        ;

        $fichaTecnicaArrayKeys = array(
            'elenco' => 'Elenco',
            'outrasInformacoes' => 'Outras Informações',
            'festivais' => 'Participações em Festivais e Mostras',
            'premios' => 'Prêmios',
        );

        return array_merge($equipeArrayKeys, $fichaTecnicaArrayKeys);
    }
}
