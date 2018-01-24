<?php

namespace App\Repository;

use App\Entity\Realizacao;

class ProjetoRepository extends AbstractCrudRepository
{
    public function list($authorizationChecker, $builderName = 'item')
    {
        $qb = parent::list($authorizationChecker, $builderName);

        return $qb
            ->innerJoin($builderName.'.realizacao', $builderName.'_realizacao')
            ->innerJoin($builderName.'_realizacao.user', $builderName.'_user')
            ->innerJoin($builderName.'_realizacao.modalidade', $builderName.'_modalidade')
        ;
    }

    public function listWhereUserIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->where($builderName.'_user = :id')
            ->setParameter('id', $id)
        ;
    }

    public function getProjetoFieldQB($builderName = 'item')
    {
        return $this->createQueryBuilder($builderName)
            ->innerJoin($builderName.'.realizacao', $builderName.'_realizacao')
            ->orderBy($builderName.'_realizacao.titulo', 'ASC')
        ;
    }

    public function getAuthorizedProjetoFieldQB($authorizationChecker, $builderName = 'item')
    {
        $qb = $this->getProjetoFieldQB($builderName);

        foreach ($qb->getQuery()->getResult() as $result) {
            if (false === $authorizationChecker->isGranted('edit', $result)) {
                $qb->andWhere($builderName.'.id != '.$result->getId());
            }
        }

        return $qb;
    }

    protected function filterValues($values)
    {
        $realizacao = $this->getArrayResultById($values['realizacao_id'], Realizacao::class, 'realizacao');
        $values = array_merge($realizacao[0], $values);
        unset($values['realizacao_id']);

        $usersDirecao = $this->find($values['id'])->getDirecao();
        $usernamesDirecao = array();
        foreach($usersDirecao as $userDirecao) {
            $usernamesDirecao[] = $userDirecao->getUsername();
        }
        $values['direcao'] = implode(', ', $usernamesDirecao);

        $usersProducao = $this->find($values['id'])->getProducao();
        $usernamesProducao = array();
        foreach($usersProducao as $userProducao) {
            $usernamesProducao[] = $userProducao->getUsername();
        }
        $values['producao'] = implode(', ', $usernamesProducao);

        $usersFotografia = $this->find($values['id'])->getFotografia();
        $usernamesFotografia = array();
        foreach($usersFotografia as $userFotografia) {
            $usernamesFotografia[] = $userFotografia->getUsername();
        }
        $values['fotografia'] = implode(', ', $usernamesFotografia);

        $usersSom = $this->find($values['id'])->getSom();
        $usernamesSom = array();
        foreach($usersSom as $userSom) {
            $usernamesSom[] = $userSom->getUsername();
        }
        $values['som'] = implode(', ', $usernamesSom);

        $usersArte = $this->find($values['id'])->getArte();
        $usernamesArte = array();
        foreach($usersArte as $userArte) {
            $usernamesArte[] = $userArte->getUsername();
        }
        $values['arte'] = implode(', ', $usernamesArte);

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        $realizacaoArrayKeys = $this->getEntityManager()
            ->getRepository(Realizacao::class)
            ->getReplaceArrayKeys()
        ;

        $projetoArrayKeys = array(
            'preProducao' => 'Data de Pré-produção',
            'dataProducao' => 'Data de Produção',
            'posProducao' => 'Data de Pós-produção',
            'direcao' => 'Direção',
            'producao' => 'Produção',
            'disciplinaFotografia' => 'Já cursou(aram) a disciplina de Fotografia e Iluminação?',
            'disciplinaSom' => 'Já cursou(aram) a disciplina de Técnica de Som em Cinema e Audiovisual?',
            'disciplinaArte' => 'Já cursou(aram) a disciplina de Design Visual?',
            'fotografia' => 'Direção de Fotografia',
            'som' => 'Direção de Som',
            'arte' => 'Direção de Arte',
            'createdIn' => 'Data e hora desta versão',
            'autor_id' => 'Autor(a) desta versão',
        );

        return array_merge($realizacaoArrayKeys, $projetoArrayKeys);
    }
}
