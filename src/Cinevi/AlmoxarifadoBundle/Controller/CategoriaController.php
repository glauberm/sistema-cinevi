<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AlmoxarifadoBundle\Entity\Categoria;
use Cinevi\AlmoxarifadoBundle\Form\Type\CategoriaType;
use Cinevi\AdminBundle\Form\Type\DeleteType;

/**
 * @RouteResource("categorias-reservaveis", pluralize=false)
 */
class CategoriaController extends RestfulCrudController implements ClassResourceInterface
{
    protected $bundleName = 'CineviAlmoxarifadoBundle:Categoria';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:Categoria';
    protected $className = Categoria::class;
    protected $routeSuffix = 'categorias-reservaveis';
    protected $formClassName = CategoriaType::class;
    protected $paramsKey = 'id';

    protected function preGet(Request $request, EntityManager $em, $obj, array $return = []) : array
    {
        $repository = $em->getRepository('CineviAlmoxarifadoBundle:Equipamento');

        $qb = $repository->list('item');
        $qb = $this->list($request, $em, $qb, 'item');

        $pagination = $this->getPagination($request, $qb, 'numResultados');

        $return['pagination'] = $pagination;

        return $return;
    }
}
