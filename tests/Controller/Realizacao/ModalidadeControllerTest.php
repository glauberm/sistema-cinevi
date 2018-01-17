<?php

namespace App\Tests\Controller\Almoxarifado;

use App\Tests\Controller\Admin\AbstractCrudControllerTest;

class ModalidadeControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/modalidades';
    protected $itemEditFilter = 'a:contains("TesteF")';
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
