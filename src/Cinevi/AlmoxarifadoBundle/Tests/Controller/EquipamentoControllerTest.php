<?php

namespace AlmoxarifadoBundle\Tests\Controller;

use AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class EquipamentoControllerTest extends RestfulCrudControllerTest
{
    protected $indexRoute = 'almoxarifado/equipamento';
    // Add
    protected $addLink = 'Adicionar';
    protected $addArrayForm = array(
        'cinevialmoxarifadobundle_equipamento[nome]'  => 'Teste0',
    );
    // Edit
    protected $editFilter = 'a:contains("Teste0")';
    protected $editLink = 'Teste0';
    protected $editArrayForm = array(
        'cinevialmoxarifadobundle_equipamento[nome]'  => 'Foo0',
    );
    protected $editButton = 'Salvar';
    // Remove
    protected $removeLink = 'Foo0';
    protected $removeFilter = '[value="Foo0"]';
    protected $removeButton = 'Remover';
}
