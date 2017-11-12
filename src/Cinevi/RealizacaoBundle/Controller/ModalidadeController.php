<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\RealizacaoBundle\Entity\Modalidade;
use Cinevi\RealizacaoBundle\Form\Type\ModalidadeType;

/**
 * @RouteResource("modalidades", pluralize=false)
 */
class ModalidadeController extends RestfulCrudController implements ClassResourceInterface
{
    protected $bundleName = 'CineviRealizacaoBundle:Modalidade';
    protected $repositoryName = 'CineviRealizacaoBundle:Modalidade';
    protected $className = Modalidade::class;
    protected $routeSuffix = 'modalidades';
    protected $formClassName = ModalidadeType::class;
    protected $paramsKey = 'id';
}
