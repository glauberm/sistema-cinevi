<?php

namespace RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use AdminBundle\Controller\AbstractCrudController;
use AdminBundle\Mailer\MailerTrait;
use RealizacaoBundle\Entity\Projeto;
use RealizacaoBundle\Form\ProjetoType;

class ProjetoController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'realizacao_projeto';
    protected $bundleName = 'RealizacaoBundle:Projeto';
    protected $repositoryName = 'RealizacaoBundle:Projeto';
    protected $className = Projeto::class;
    protected $formClassName = ProjetoType::class;
    protected $paramsKey = 'id';

    protected function postFormNew(Form $form, EntityManager $em) : Form
    {
        $form = $this->checkCopiaFinal($form);

        return $form;
    }

    protected function postFormEdit($obj, Form $form, EntityManager $em) : Form
    {
        $form = $this->checkCopiaFinal($form, $obj);

        return $form;
    }

    protected function postNew($obj, EntityManager $em)
    {
        $subject = 'Novo Projeto: '.$obj->getRealizacao()->getTitulo();
        $path = $this->generateUrl($this->canonicalName.'_show', array(
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

        if(!empty($user) && ($user->getProfessor() !== true || !$this->isGranted('ROLE_DEPARTAMENTO'))) {
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
