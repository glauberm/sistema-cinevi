<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class CategoriaControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'categorias';
    // Add
    protected $addArrayForm = array(
        'categoria[nome]' => 'Teste',
    );
    // Edit
    protected $itemFilter = 'a:contains("Teste")';
    protected $itemLink = 'Teste';
    protected $editArrayForm = array(
        'categoria[nome]' => 'Etset',
    );
    // Remove
    protected $removeLink = 'Etset';
    protected $removeFilter = '[value="Etset"]';
}
