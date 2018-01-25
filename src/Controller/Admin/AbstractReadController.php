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
    protected $historicoRepository;
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
        $data = $this->showHistorico($request, $em, $paginator, $obj, $data);
        $data = $this->preShow($request, $em, $ac, $paginator, $obj, $data);

        return $this->createView($this->showTemplate, $data);
    }

    public function csv(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac)
    {
        $repository = $em->getRepository($this->repositoryName);
        $qb = $repository->list($ac);
        $arrayResult = $repository->getArrayResultWithKeys($qb);

        return new CsvResponse($request, $this->canonicalName, $arrayResult);
    }

    public function historico(EntityManagerInterface $em, $id)
    {
        $historico = $em->getRepository($this->historicoRepository)->find($id);
        $this->denyAccessUnlessGranted('view', $historico);

        return $this->createView('historico.html.twig', [
            'item' => $historico
        ]);
    }

    protected function createPagination(Request $request, PaginatorInterface $paginator, $qb, $var = null)
    {
        if($request->query->get('num_linhas'.$var)) {
            $numResults = $request->query->get('num_linhas'.$var);
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
                'filterFieldParameterName' => 'filtro_campo'.$var,
                'filterValueParameterName' => 'filtro_valor'.$var,
                'alias' => $var
            )
        );

        return $pagination;
    }

    protected function preShow(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        return $data;
    }

    protected function showHistorico(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        $historicoRepository = $em->getRepository($this->historicoRepository);
        $historicoQb = $historicoRepository->list($obj);
        $paginationHistorico = $this->createPagination($request, $paginator, $historicoQb, '_historico');
        $data['paginationHistorico'] = $paginationHistorico;

        return $data;
    }
}
