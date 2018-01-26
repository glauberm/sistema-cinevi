<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Controller\Admin\AbstractCrudController;
use App\Entity\Modalidade;
use App\Entity\ModalidadeHistorico;
use App\Entity\Projeto;
use App\Entity\CopiaFinal;
use App\Form\Realizacao\ModalidadeType;

class ModalidadeController extends AbstractCrudController
{
    protected $canonicalName = 'realizacao_modalidade';
    protected $templateDir = 'realizacao/modalidade';
    protected $repositoryName = Modalidade::class;
    protected $historicoRepository = ModalidadeHistorico::class;
    protected $className = Modalidade::class;
    protected $formClassName = ModalidadeType::class;
    protected $paramsKey = 'id';

    protected function preShow(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        $rProjeto = $em->getRepository(Projeto::class);
        $rCopiaFinal = $em->getRepository(CopiaFinal::class);

        $qbProjeto = $rProjeto->list($ac, 'projeto');
        $qbCopiaFinal = $rCopiaFinal->list($ac, 'copia_final');

        $qbProjeto = $rProjeto->listWhereModalidadeIs($qbProjeto, $obj->getId(), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->listWhereModalidadeIs($qbCopiaFinal, $obj->getId(), 'copia_final');

        $paginationProjeto = $this->createPagination($request, $paginator, $qbProjeto, '_projeto');
        $paginationCopiaFinal = $this->createPagination($request, $paginator, $qbCopiaFinal, '_copia_final');

        $data['paginationProjeto'] = $paginationProjeto;
        $data['paginationCopiaFinal'] = $paginationCopiaFinal;

        return $data;
    }
}
