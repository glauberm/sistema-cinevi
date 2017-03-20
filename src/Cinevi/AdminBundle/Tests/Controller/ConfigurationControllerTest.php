<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class CategoriaControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'configurations';
    // Edit
    protected $itemEditFilter = 'a:contains("Sim")';
    protected $itemEditLink = 'Sim';
    // Remove
    protected $itemRemoveLink = 'Não';
    protected $itemRemoveFilter = '[value="0"]';


    protected function getAddArrayForm()
    {
        return array(
            'configuration[reservasFechadas]' => '1',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'configuration[reservasFechadas]' => '0',
        );
    }
}
