<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Controller\Admin\AbstractCrudController;
use App\Mailer\MailerTrait;
use App\Entity\Projeto;
use App\Form\Realizacao\ProjetoType;

class ProjetoController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'realizacao_projeto';
    protected $templateDir = 'realizacao/projeto';
    protected $repositoryName = 'App\Entity\Projeto';
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
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $template = $this->templateDir.'/email';
        $emails = array(
            'almoxarifadocinemauff@gmail.com',
            'acervodearteuff@gmail.com',
            'comissaoproducaouff@gmail.com'
        );
        foreach($emails as $email) {
            $to = $email;
            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }

        $template = $this->templateDir.'/email_user';
        $to = $obj->getRealizacao()->getUser()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_professor';
        $to = $obj->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_equipe';
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