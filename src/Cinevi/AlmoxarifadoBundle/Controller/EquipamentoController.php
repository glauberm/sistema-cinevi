<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AlmoxarifadoBundle\Entity\Equipamento;
use Cinevi\AlmoxarifadoBundle\Form\Type\EquipamentoType;

class EquipamentoController extends RestfulCrudController
{
    protected $bundleName = 'CineviAlmoxarifadoBundle:Equipamento';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:Equipamento';
    protected $className = Equipamento::class;
    protected $routeSuffix = 'equipamento';
    protected $label = 'equipamento';
    protected $formClassName = EquipamentoType::class;

    protected function listar($builder, EntityManager $em)
    {
        return $builder->join('item.categoria', 'c');
    }
}
