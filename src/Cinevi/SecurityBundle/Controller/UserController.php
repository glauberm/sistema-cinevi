<?php

namespace Cinevi\SecurityBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\SecurityBundle\Entity\User;
use Cinevi\SecurityBundle\Form\Type\UserType;

/**
 * @RouteResource("Usuarios", pluralize=false)
 */
class UserController extends RestfulCrudController implements ClassResourceInterface
{
    protected $bundleName = 'CineviSecurityBundle:User';
    protected $repositoryName = 'CineviSecurityBundle:User';
    protected $className = User::class;
    protected $routeSuffix = 'usuarios';
    protected $formClassName = UserType::class;
    protected $paramsKey = 'id';
    private $confirmado;

    use MailerTrait;

    protected function preFormPut($obj, Form $form, EntityManager $em) : Form
    {
        $this->confirmado = $obj->getConfirmado();

        return $form;
    }

    protected function postPut($obj, EntityManager $em)
    {
        if($this->confirmado == false && $obj->getConfirmado() == true) {
            $template = $this->bundleName.':email';

            $subject = 'Confirmação de Cadastro: '.$obj->getUsername();

            $path = $this->generateUrl('index', array(), true);

            $to = $obj->getEmail();

            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }

        return $obj;
    }
}
