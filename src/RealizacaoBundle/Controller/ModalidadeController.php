<?php

namespace RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Controller\AbstractCrudController;
use RealizacaoBundle\Entity\Modalidade;
use RealizacaoBundle\Form\ModalidadeType;

class ModalidadeController extends AbstractCrudController
{
    protected $canonicalName = 'realizacao_modalidade';
    protected $bundleName = 'RealizacaoBundle:Modalidade';
    protected $repositoryName = 'RealizacaoBundle:Modalidade';
    protected $className = Modalidade::class;
    protected $formClassName = ModalidadeType::class;
    protected $paramsKey = 'id';
}
