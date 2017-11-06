<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class ModalidadeControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 's/modalidades';
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
