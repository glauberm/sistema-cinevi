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
    protected $editFilter = 'a:contains("Teste")';
    protected $editLink = 'Teste';
    protected $editArrayForm = array(
        'categoria[nome]' => 'Etset',
    );
    // Remove
    protected $removeLink = 'Etset';
    protected $removeFilter = '[value="Etset"]';
}
