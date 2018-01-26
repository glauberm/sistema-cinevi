<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Controller\Admin\AbstractCrudController;
use App\Entity\Funcao;
use App\Entity\FuncaoHistorico;
use App\Entity\Equipe;
use App\Form\Realizacao\FuncaoType;

class FuncaoController extends AbstractCrudController
{
    protected $canonicalName = 'realizacao_funcao';
    protected $templateDir = 'realizacao/funcao';
    protected $repositoryName = Funcao::class;
    protected $historicoRepository = FuncaoHistorico::class;
    protected $className = Funcao::class;
    protected $formClassName = FuncaoType::class;
    protected $paramsKey = 'id';
}
