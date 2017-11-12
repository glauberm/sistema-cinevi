<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class ModalidadeControllerTest extends RestfulCrudControllerTest
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
}
