<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\RealizacaoBundle\Entity\Projeto;
use Cinevi\RealizacaoBundle\Form\Type\ProjetoType;

class ProjetoController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviRealizacaoBundle:Projeto';
    protected $repositoryName = 'CineviRealizacaoBundle:Projeto';
    protected $className = Projeto::class;
    protected $routeSuffix = 'projeto';
    protected $formClassName = ProjetoType::class;

    protected function listar($builder, EntityManager $em)
    {
        return $builder->join('item.realizacao', 'r')->leftJoin('r.user', 'u');
    }

    protected function posCriar(Form $form, EntityManager $em)
    {
        $form = $this->checaCopiaFinal($form);

        return $form;
    }

    protected function posEditar($obj, Form $form, EntityManager $em)
    {
        $form = $this->checaCopiaFinal($form, $obj);

        return $form;
    }

    protected function posPersist($obj, EntityManager $em)
    {
        $template = $this->bundleName.':email';

        $assunto = 'Novo Projeto: '.$obj->getRealizacao()->getTitulo();

        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'id' => $obj->getId(),
        ), true);

        // Envia email para os emails no array
        $emails = array(
            'almoxarifadocinemauff@gmail.com',
            'acervodearteuff@gmail.com',
            'comissaoproducaouff@gmail.com'
        );

        foreach($emails as $email) {
            $destinatario = $email;
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        // Email para o usuário
        $destinatario = $obj->getRealizacao()->getUser()->getEmail();
        $template = $this->bundleName.':email-user';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        // Email para o professor
        $destinatario = $obj->getRealizacao()->getProfessor()->getEmail();
        $template = $this->bundleName.':email-professor';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        // Email para a equipe
        $emailsEquipes = array();

        $template = $this->bundleName.':email-equipe';

        foreach($obj->getDirecao() as $user) {
            $emailsEquipes[] = $user->getEmail();
        }
        foreach($obj->getProducao() as $user) {
            $emailsEquipes[] = $user->getEmail();
        }
        foreach($obj->getFotografia() as $user) {
            $emailsEquipes[] = $user->getEmail();
        }
        foreach($obj->getSom() as $user) {
            $emailsEquipes[] = $user->getEmail();
        }
        foreach($obj->getArte() as $user) {
            $emailsEquipes[] = $user->getEmail();
        }

        $emailsEquipes = array_unique($emailsEquipes);

        foreach($emailsEquipes as $email) {
            $destinatario = $email;
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        return $obj;
    }

    private function checaCopiaFinal($form, $obj = null)
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
                    $mensagem = 'Antes de registrar um novo projeto com este responsável, você precisa registrar a cópia final do projeto '.$realizacao->getTitulo().'.';
                    $form->get('realizacao')->get('user')->addError(new FormError($mensagem));
                }
            }
        }

        return $form;
    }
}
