<?php

namespace Cinevi\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Form\Type\DeleteType;
use Cinevi\AdminBundle\Http\CsvResponse;

abstract class RestfulReadController extends RestfulCommonController implements ClassResourceInterface
{
    protected $repositoryName;
    protected $paramsKey;
    protected $listTemplate = 'list.html.twig';
    protected $showTemplate = 'show.html.twig';

    public function cgetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository($this->repositoryName);

        $qb = $repository->list();
        $qb = $this->list($request, $em, $qb);

        $return = [];
        $return = $this->preCget($request, $em, $return);

        $pagination = $this->getPagination($request, $qb);

        $view = $this->getView($pagination, $this->listTemplate, 'pagination', $return);

        return $view;
    }

    public function getAction(Request $request, $params)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = $em->getRepository($this->repositoryName)->findOneBy(array(
            $this->paramsKey => $params
        ));

        $this->denyAccessUnlessGranted('view', $obj);

        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, ['id' => $obj->getId()]);

        $return =  ['deleteForm' => $deleteForm->createView()];

        $return = $this->preGet($request, $em, $obj, $return);

        $view = $this->getView($obj, $this->showTemplate, 'item', $return);

        return $view;
    }

    public function getCsvAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository($this->bundleName);

        $qb = $repository->list();
        $qb = $this->list($request, $em, $qb);

        $itens = $repository->getCsv($qb);

        $keys = array();
        foreach ($itens as $item) {
            $keys[] = array_keys($item);
            break;
        }

        $arrayResult = array_merge($keys, $itens);

        return new CsvResponse($this->routeSuffix, $arrayResult);
    }

    protected function list(Request $request, EntityManager $em, $qb, $builderName = 'item')
    {
        $checker = $this->get('security.authorization_checker');

        foreach ($qb->getQuery()->getResult() as $result) {
            if ($checker->isGranted('view', $result) === false) {
                $qb->andWhere($builderName.'.id != '.$result->getId());
            }
        }

        $qb = $this->preList($request, $em, $qb);

        return $qb;
    }

    protected function getPagination(Request $request, $qb, $getVar = null)
    {
        $paginator = $this->get('knp_paginator');

        $numResults = $request->query->get('numResultados'.$getVar) ? $request->query->get('numResultados'.$getVar) : 10;

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $numResults,
            array(
                'wrap-queries' => true,
                'pageParameterName' => 'page'.$getVar,
                'sortFieldParameterName' => 'sort'.$getVar,
                'sortDirectionParameterName' => 'direction'.$getVar,
            )
        );

        return $pagination;
    }

    protected function preCget(Request $request, EntityManager $em, array $return = []) : array
    {
        return $return;
    }

    protected function preGet(Request $request, EntityManager $em, $obj, array $return = []) : array
    {
        return $return;
    }

    protected function preList(Request $request, EntityManager $em, $qb)
    {
        return $qb;
    }
}
