<?php

namespace App\Tests\Almoxarifado;

use App\Tests\Admin\AbstractCrudControllerTest;

class ModalidadeControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/modalidades';
    protected $itemEditFilter = 'h1:contains("TesteF")';
    protected $itemEditLink = 'TesteF';
    protected $itemRemoveLink = 'FEtset';
    protected $itemRemoveFilter = '[value="FEtset"]';


    protected function getAddArrayForm()
    {
        return array(
            'modalidade[nome]' => 'TesteF',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'modalidade[nome]' => 'FEtset',
        );
    }

    protected function doAfterList($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Nome')->link());

        return $crawler;
    }
}
