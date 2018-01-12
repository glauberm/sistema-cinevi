<?php

namespace AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Paginator;
use AdminBundle\Http\CsvResponse;

abstract class AbstractReadController extends AbstractCommonController
{
    protected $repositoryName;
    protected $listTemplate = 'list.html.twig';
    protected $showTemplate = 'show.html.twig';

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository($this->repositoryName);
        $qb = $repository->list($this->get('security.authorization_checker'));
        $pagination = $this->createPagination($request, $this->get('knp_paginator'), $qb);
        $data = ['pagination' => $pagination];

        return $this->createView($this->listTemplate, $data);
    }

    public function showAction(Request $request, $params)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository($this->repositoryName)->findOneBy([
            $this->paramsKey => $params
        ]);
        $this->denyAccessUnlessGranted('view', $obj);
        $deleteForm = $this->createDeleteForm($obj);
        $data = ['item' => $obj, 'delete_form' => $deleteForm->createView()];
        $data = $this->preShow($request, $em, $obj, $data);

        return $this->createView($this->showTemplate, $data);
    }

    public function getCsvAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository($this->repositoryName);
        $qb = $repository->list($authorizationChecker);
        $itens = $repository->getCsv($qb);
        $keys = [];

        foreach ($itens as $item) {
            $keys[] = array_keys($item);
            break;
        }

        $arrayResult = array_merge($keys, $itens);

        return new CsvResponse($this->canonicalName, $arrayResult);
    }

    protected function createPagination(Request $request, Paginator $paginator, $qb, $var = null)
    {
        if($request->query->get('numResultados'.$var)) {
            $numResults = $request->query->get('numResultados'.$var);
        } else {
            $numResults = 10;
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $numResults,
            array(
                'pageParameterName' => 'pagina'.$var,
                'sortFieldParameterName' => 'classificacao'.$var,
                'sortDirectionParameterName' => 'direcao'.$var
            )
        );

        return $pagination;
    }

    protected function preShow(Request $request, EntityManager $em, $obj, array $data = []) : array
    {
        return $data;
    }
}
