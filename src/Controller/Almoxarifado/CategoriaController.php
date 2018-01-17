<?php

namespace App\Controller\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use App\Controller\Admin\AbstractCrudController;
use App\Entity\Categoria;
use App\Entity\Equipamento;
use App\Form\Almoxarifado\CategoriaType;

class CategoriaController extends AbstractCrudController
{
    protected $canonicalName = 'almoxarifado_categoria';
    protected $templateDir = 'almoxarifado/categoria';
    protected $repositoryName = Categoria::class;
    protected $className = Categoria::class;
    protected $formClassName = CategoriaType::class;
    protected $paramsKey = 'id';

    protected function preShow(Request $request, EntityManager $em, $obj, array $data = []) : array
    {
        $repository = $em->getRepository(Equipamento::class);
        $qb = $repository->list($this->get('security.authorization_checker'), 'equipamento');
        $qb = $repository->listWhereCategoriaIs($qb, $obj->getId(), 'equipamento');
        $pagination = $this->createPagination($request, $this->get('knp_paginator'), $qb);
        $data['pagination'] = $pagination;

        return $data;
    }
}
