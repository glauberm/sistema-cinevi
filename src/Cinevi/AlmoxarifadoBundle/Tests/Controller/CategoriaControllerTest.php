<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class CategoriaControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'categorias';
    // Edit
    protected $itemEditFilter = 'a:contains("TesteC")';
    protected $itemEditLink = 'TesteC';
    // Remove
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
}