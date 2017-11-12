<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

/**
 * @TODO: Actually update entity in email tests.
 */
class CategoriaControllerTest extends RestfulCrudControllerTest
{
    protected $indexRoute = 's/categorias-reservaveis';
    protected $itemEditFilter = 'a:contains("TesteC")';
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
