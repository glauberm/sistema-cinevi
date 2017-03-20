<?php

namespace Cinevi\SecurityBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\SecurityBundle\Entity\User;
use Cinevi\SecurityBundle\Form\Type\UserType;

class UserController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviSecurityBundle:User';
    protected $repositoryName = 'CineviSecurityBundle:User';
    protected $className = User::class;
    protected $routeSuffix = 'user';
    protected $label = 'usuário';
    protected $formClassName = UserType::class;

    private $confirmado;

    protected function preEditar($obj, Form $form, EntityManager $em)
    {
        $this->confirmado = $obj->getConfirmado();

        return $form;
    }

    protected function posMerge($obj, EntityManager $em)
    {
        if($this->confirmado == false && $obj->getConfirmado() == true) {
            $template = $this->bundleName.':email';

            $assunto = 'Confirmação de Cadastro: '.$obj->getUsername();

            $path = $this->generateUrl('index', array(), true);

            $destinatario = $obj->getEmail();
            
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        return $obj;
    }
}
