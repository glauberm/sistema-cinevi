<?php

namespace App\Repository;

use App\Entity\Realizacao;
use App\Entity\Projeto;
use App\Entity\FichaTecnica;

class CopiaFinalRepository extends AbstractCrudRepository
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
            ->where($builderName.'_realizacao.user = :id')
            ->setParameter('id', $id)
        ;
    }

    public function listWhereModalidadeIs($qb, $id, $builderName = 'item')
    {
        return $qb
            ->where($builderName.'_realizacao.modalidade = :id')
            ->setParameter('id', $id)
        ;
    }

    protected function filterValues($values)
    {
        $realizacao = $this->getArrayResultById($values['realizacao_id'], Realizacao::class, 'realizacao');
        if(!empty($realizacao)) $values = array_merge($realizacao[0], $values);
        unset($values['realizacao_id']);

        if($values['projeto_id']) {
            $projeto = $this->getEntityManager()
                ->getRepository(Projeto::class)->find($values['projeto_id'])
            ;
            $values['projeto_id'] = $projeto->getRealizacao()->getTitulo();
        } else {
            $values['projeto_id'] = 'Outro';
        }

        $fichaTecnica = $this->getArrayResultById($values['ficha_tecnica_id'], FichaTecnica::class, 'ficha_tecnica');
        if(!empty($fichaTecnica)) $values = array_merge($values, $fichaTecnica[0]);
        unset($values['ficha_tecnica_id']);

        return $values;
    }

    protected function getReplaceArrayKeys()
    {
        $realizacaoArrayKeys = $this->getEntityManager()
            ->getRepository(Realizacao::class)
            ->getReplaceArrayKeys()
        ;

        $copiaFinalArrayKeys = array(
            'cromia' => 'Cromia',
            'proporcao' => 'Proporção',
            'formato' => 'Formato',
            'formatoDigitalNativo' => 'Formato Digital Nativo',
            'codec' => 'Codec',
            'container' => 'Container (wrapper)',
            'taxaBits' => 'Taxa de bits',
            'velocidade' => 'Velocidade',
            'som' => 'Som',
            'resolucaoAudioDigital' => 'Resolução de Áudio Digital',
            'dcp' => 'Foi feito DCP?',
            'suporteMatrizDigital' => 'Suporte de Matriz Digital',
            'camera' => 'Câmera',
            'captacaoSom' => 'Equipamentos de Captação de Som',
            'softwareEdicao' => 'Software de Edição',
            'orcamento' => 'Orçamento',
            'fontesFinanciamento' => 'Fontes de Financiamento',
            'apoiadores' => 'Apoiadores',
            'duracao' => 'Duração',
            'linkVideo' => 'Link para o vídeo',
            'senhaVideo' => 'Senha do vídeo',
            'confirmado' => 'Confirmado',
            'projeto_id' => 'Projeto',
            'createdIn' => 'Data e hora desta versão',
            'autor_id' => 'Autor(a) desta versão',
        );

        $fichaTecnicaArrayKeys = $this->getEntityManager()
            ->getRepository(FichaTecnica::class)
            ->getReplaceArrayKeys()
        ;

        return array_merge($realizacaoArrayKeys, $copiaFinalArrayKeys, $fichaTecnicaArrayKeys);
    }
}
