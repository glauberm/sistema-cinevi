<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Admin\AbstractCrudController;
use App\Entity\Funcao;
use App\Form\Realizacao\FuncaoType;

class FuncaoController extends AbstractCrudController
{
    protected $canonicalName = 'realizacao_funcao';
    protected $templateDir = 'realizacao/funcao';
    protected $repositoryName = Funcao::class;
    protected $className = Funcao::class;
    protected $formClassName = FuncaoType::class;
    protected $paramsKey = 'id';
}
