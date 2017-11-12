<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\RealizacaoBundle\Entity\Projeto;
use Cinevi\RealizacaoBundle\Form\Type\ProjetoType;

/**
 * @RouteResource("projetos", pluralize=false)
 */
class ProjetoController extends RestfulCrudController implements ClassResourceInterface
{
    use MailerTrait;

    protected $bundleName = 'CineviRealizacaoBundle:Projeto';
    protected $repositoryName = 'CineviRealizacaoBundle:Projeto';
    protected $className = Projeto::class;
    protected $routeSuffix = 'projetos';
    protected $formClassName = ProjetoType::class;
    protected $paramsKey = 'id';

    protected function postFormPost(Form $form, EntityManager $em) : Form
    {
        $form = $this->checkCopiaFinal($form);

        return $form;
    }

    protected function postFormPut($obj, Form $form, EntityManager $em) : Form
    {
        $form = $this->checkCopiaFinal($form, $obj);

        return $form;
    }

    protected function postPost($obj, EntityManager $em)
    {
        $subject = 'Novo Projeto: '.$obj->getRealizacao()->getTitulo();
        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'params' => $obj->getId(),
        ), true);

        $template = $this->bundleName.':email';
        $emails = array(
            'almoxarifadocinemauff@gmail.com',
            'acervodearteuff@gmail.com',
            'comissaoproducaouff@gmail.com'
        );
        foreach($emails as $email) {
            $to = $email;
            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }

        $template = $this->bundleName.':email-user';
        $to = $obj->getRealizacao()->getUser()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-professor';
        $to = $obj->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-equipe';
        $emailsEquipes = array();
        foreach($obj->getDirecao() as $user) { $emailsEquipes[] = $user->getEmail(); }
        foreach($obj->getProducao() as $user) { $emailsEquipes[] = $user->getEmail(); }
        foreach($obj->getFotografia() as $user) { $emailsEquipes[] = $user->getEmail(); }
        foreach($obj->getSom() as $user) { $emailsEquipes[] = $user->getEmail(); }
        foreach($obj->getArte() as $user) { $emailsEquipes[] = $user->getEmail(); }
        $emailsEquipes = array_unique($emailsEquipes);
        foreach($emailsEquipes as $email) {
            $to = $email;
            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }
    }

    private function checkCopiaFinal(Form $form, $obj = null)
    {
        $user = $form->get('realizacao')->get('user')->getData();

        if($user->getProfessor() !== true && !$this->isGranted('ROLE_DEPARTAMENTO')) {
            $projetosArray = array();
            foreach($user->getRealizacaos() as $realizacao) {
                if($realizacao->getProjeto()) {
                    $projetosArray[] = $realizacao->getProjeto();
                }
            }
            foreach($projetosArray as $projeto) {
                if($projeto != $obj && !$projeto->getCopiaFinal()) {
                    $message = 'Para registrar um novo projeto com este responsável, é preciso registrar a cópia final do seu projeto '.$realizacao->getTitulo().'.';
                    $form->get('realizacao')->get('user')->addError(new FormError($message));
                }
            }
        }

        return $form;
    }
}
