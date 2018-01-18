<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Http\CsvResponse;

abstract class AbstractReadController extends AbstractCommonController
{
    protected $repositoryName;
    protected $listTemplate = 'list.html.twig';
    protected $showTemplate = 'show.html.twig';

    public function index(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator)
    {
        $repository = $em->getRepository($this->repositoryName);
        $qb = $repository->list($ac);
        $pagination = $this->createPagination($request, $paginator, $qb);
        $data = ['pagination' => $pagination];

        return $this->createView($this->listTemplate, $data);
    }

    public function show(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $params)
    {
        $obj = $em->getRepository($this->repositoryName)->findOneBy([
            $this->paramsKey => $params
        ]);
        $this->denyAccessUnlessGranted('view', $obj);
        $deleteForm = $this->createDeleteForm($obj);
        $data = ['item' => $obj, 'delete_form' => $deleteForm->createView()];
        $data = $this->preShow($request, $em, $ac, $paginator, $obj, $data);

        return $this->createView($this->showTemplate, $data);
    }

    public function csv(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac)
    {
        $repository = $em->getRepository($this->repositoryName);
        $qb = $repository->list($ac);
        $itens = $repository->getCsv($qb);
        $keys = [];

        foreach ($itens as $item) {
            $keys[] = array_keys($item);
            break;
        }

        $arrayResult = array_merge($keys, $itens);

        return new CsvResponse($this->canonicalName, $arrayResult);
    }

    protected function createPagination(Request $request, PaginatorInterface $paginator, $qb, $var = null)
    {
        if($request->query->get('numResultados'.$var)) {
            $numResults = $request->query->get('numResultados'.$var);
        } else {
            $numResults = 10;
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('pagina'.$var, 1),
            $numResults,
            array(
                'pageParameterName' => 'pagina'.$var,
                'sortFieldParameterName' => 'classificacao'.$var,
                'sortDirectionParameterName' => 'direcao'.$var,
                'distict' => true,
                'filterFieldParameterName' => 'filtroCampo'.$var,
                'filterValueParameterName' => 'filtroValor'.$var,
                'alias' => $var
            )
        );

        return $pagination;
    }

    protected function preShow(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        return $data;
    }
}
