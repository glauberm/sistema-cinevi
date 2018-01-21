<?php

namespace App\Repository;

use App\Repository\AbstractCrudRepository;

class CopiaFinalRepository extends AbstractCrudRepository
{
    protected $replaceArrayKeys = array(
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
        // 'createdIn' => '',
        // 'updatedIn' => '',
        // 'realizacao_id' => '',
        // 'projeto_id' => '',
        // 'ficha_tecnica_id' => '',
    );

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
}
