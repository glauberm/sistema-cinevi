<?php

namespace App\Tests\Almoxarifado;

use App\Tests\Admin\AbstractCrudControllerTest;

class CategoriaControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/categorias_reservaveis';
    protected $itemEditFilter = 'h1:contains("TesteC")';
    protected $itemEditLink = 'TesteC';
    protected $itemRemoveLink = 'CEtset';
    protected $itemRemoveFilter = '[value="CEtset"]';

    protected function getAddArrayForm()
    {
        return array(
            'categoria[nome]' => 'TesteC',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'categoria[nome]' => 'CEtset',
        );
    }

    protected function doAfterList($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Nome')->link());

        return $crawler;
    }

    protected function doAfterShow($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Cód.')->link());
        $crawler = $this->client->click($crawler->selectLink('Nome')->link());
        $crawler = $this->client->click($crawler->selectLink('Categoria')->link());
        $crawler = $this->client->click($crawler->selectLink('Manutenção')->link());
        $crawler = $this->client->click($crawler->selectLink('Devolução Atrasada?')->link());

        return $crawler;
    }
}
