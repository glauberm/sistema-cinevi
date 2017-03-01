<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class FuncaoControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'funcaos';
    // Edit
    protected $itemEditFilter = 'a:contains("TesteF")';
    protected $itemEditLink = 'TesteF';
    // Remove
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
}
