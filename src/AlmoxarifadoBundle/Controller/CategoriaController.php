<?php

namespace AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use AdminBundle\Controller\AbstractCrudController;
use AlmoxarifadoBundle\Entity\Categoria;
use AlmoxarifadoBundle\Form\CategoriaType;
use AdminBundle\Form\DeleteType;

class CategoriaController extends AbstractCrudController
{
    protected $canonicalName = 'almoxarifado_categoria';
    protected $bundleName = 'AlmoxarifadoBundle:Categoria';
    protected $repositoryName = 'AlmoxarifadoBundle:Categoria';
    protected $className = Categoria::class;
    protected $formClassName = CategoriaType::class;
    protected $paramsKey = 'id';

    protected function preShow(Request $request, EntityManager $em, $obj, array $data = []) : array
    {
        $repository = $em->getRepository('AlmoxarifadoBundle:Equipamento');
        $qb = $repository->list($this->get('security.authorization_checker'), 'equipamento');
        $qb = $repository->listWhereCategoriaIs($qb, $obj->getId(), 'equipamento');
        $pagination = $this->createPagination($request, $this->get('knp_paginator'), $qb);
        $data['pagination'] = $pagination;

        return $data;
    }
}
