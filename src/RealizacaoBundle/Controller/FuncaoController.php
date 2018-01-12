<?php

namespace RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Controller\AbstractCrudController;
use RealizacaoBundle\Entity\Funcao;
use RealizacaoBundle\Form\FuncaoType;

class FuncaoController extends AbstractCrudController
{
    protected $canonicalName = 'realizacao_funcao';
    protected $bundleName = 'RealizacaoBundle:Funcao';
    protected $repositoryName = 'RealizacaoBundle:Funcao';
    protected $className = Funcao::class;
    protected $formClassName = FuncaoType::class;
    protected $paramsKey = 'id';
}
