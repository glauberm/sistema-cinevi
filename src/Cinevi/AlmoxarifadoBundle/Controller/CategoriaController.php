<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AlmoxarifadoBundle\Entity\Categoria;
use Cinevi\AlmoxarifadoBundle\Form\Type\CategoriaType;

class CategoriaController extends RestfulCrudController
{
    protected $bundleName = 'CineviAlmoxarifadoBundle:Categoria';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:Categoria';
    protected $className = Categoria::class;
    protected $routeSuffix = 'categoria';
    protected $label = 'categoria';
    protected $formClassName = CategoriaType::class;
}
