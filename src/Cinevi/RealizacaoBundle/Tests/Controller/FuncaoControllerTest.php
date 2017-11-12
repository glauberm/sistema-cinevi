<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class FuncaoControllerTest extends RestfulCrudControllerTest
{
    protected $indexRoute = 's/funcoes';
    protected $itemEditFilter = 'a:contains("TesteF")';
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
