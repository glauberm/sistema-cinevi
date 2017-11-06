<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\RealizacaoBundle\Entity\Funcao;
use Cinevi\RealizacaoBundle\Form\Type\FuncaoType;

/**
 * @RouteResource("funcoes", pluralize=false)
 */
class FuncaoController extends RestfulCrudController implements ClassResourceInterface
{
    protected $bundleName = 'CineviRealizacaoBundle:Funcao';
    protected $repositoryName = 'CineviRealizacaoBundle:Funcao';
    protected $className = Funcao::class;
    protected $routeSuffix = 'funcoes';
    protected $formClassName = FuncaoType::class;
    protected $paramsKey = 'id';
}
