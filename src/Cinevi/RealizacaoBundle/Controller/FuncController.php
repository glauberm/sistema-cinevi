<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\RealizacaoBundle\Entity\Funcao;
use Cinevi\RealizacaoBundle\Form\Type\FuncaoType;

class FuncController extends RestfulCrudController
{
    protected $bundleName = 'CineviRealizacaoBundle:Funcao';
    protected $repositoryName = 'CineviRealizacaoBundle:Funcao';
    protected $className = Funcao::class;
    protected $routeSuffix = 'func';
    protected $formClassName = FuncaoType::class;
}