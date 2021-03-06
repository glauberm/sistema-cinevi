<?php

namespace App\Tests\Almoxarifado;

use App\Tests\Admin\AbstractCrudControllerTest;

class FuncaoControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/funcoes';
    protected $itemEditFilter = 'h1:contains("TesteF")';
    protected $itemEditLink = 'TesteF';
    protected $itemRemoveLink = 'FEtset';
    protected $itemRemoveFilter = '[value="FEtset"]';


    protected function getAddArrayForm()
    {
        return array(
            'funcao[nome]' => 'TesteF',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'funcao[nome]' => 'FEtset',
        );
    }

    protected function doAfterList($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Nome')->link());

        return $crawler;
    }
}
