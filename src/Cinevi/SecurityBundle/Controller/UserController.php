<?php

namespace Cinevi\SecurityBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\SecurityBundle\Entity\User;
use Cinevi\SecurityBundle\Form\Type\UserType;

class UserController extends RestfulCrudController
{
    protected $bundleName = 'CineviSecurityBundle:User';
    protected $repositoryName = 'CineviSecurityBundle:User';
    protected $className = User::class;
    protected $routeSuffix = 'user';
    protected $label = 'usuário';
    protected $formClassName = UserType::class;
}
