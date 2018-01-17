<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Admin\AbstractCrudController;
use App\Entity\Modalidade;
use App\Form\Realizacao\ModalidadeType;

class ModalidadeController extends AbstractCrudController
{
    protected $canonicalName = 'realizacao_modalidade';
    protected $templateDir = 'realizacao/modalidade';
    protected $repositoryName = 'App\Entity\Modalidade';
    protected $className = Modalidade::class;
    protected $formClassName = ModalidadeType::class;
    protected $paramsKey = 'id';
}
