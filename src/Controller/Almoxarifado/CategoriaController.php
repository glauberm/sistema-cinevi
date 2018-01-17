<?php

namespace App\Controller\Almoxarifado;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Knp\Component\Pager\PaginatorInterface;
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

    protected function preShow(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        $repository = $em->getRepository(Equipamento::class);
        $qb = $repository->list($ac, 'equipamento');
        $qb = $repository->listWhereCategoriaIs($qb, $obj->getId(), 'equipamento');
        $pagination = $this->createPagination($request, $paginator, $qb);
        $data['pagination'] = $pagination;

        return $data;
    }
}
