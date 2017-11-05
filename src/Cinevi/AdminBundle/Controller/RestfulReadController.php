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

        $qb = $repository->list('item');
        $qb = $this->list($request, $em, $qb, 'item');

        $return = [];
        $return = $this->preCget($request, $em, $return);

        $pagination = $this->getPagination($request, $qb, 'numResultados');

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

        $itens = $em->getRepository($this->bundleName)->getCsv();

        $keys = array();
        foreach ($itens as $item) {
            $keys[] = array_keys($item);
            break;
        }

        $arrayResult = array_merge($keys, $itens);

        return new CsvResponse($this->routeSuffix, $arrayResult);
    }

    protected function list(Request $request, EntityManager $em, $qb, $builderName)
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

    protected function getPagination(Request $request, $qb, $getVarNumResults)
    {
        $paginator = $this->get('knp_paginator');

        $numResults = $request->query->get($getVarNumResults) ? $request->query->get($getVarNumResults) : 10;

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $numResults,
            array(
                'wrap-queries' => true,
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
