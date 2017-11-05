<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\RealizacaoBundle\Entity\CopiaFinal;
use Cinevi\RealizacaoBundle\Form\Type\CopiaFinalType;

/**
 * @RouteResource("copias-finais", pluralize=false)
 */
class CopiaFinalController extends RestfulCrudController
{
    protected $bundleName = 'CineviRealizacaoBundle:CopiaFinal';
    protected $repositoryName = 'CineviRealizacaoBundle:CopiaFinal';
    protected $className = CopiaFinal::class;
    protected $routeSuffix = 'copias-finais';
    protected $formClassName = CopiaFinalType::class;
    protected $paramsKey = 'id';
    private $confirmed;

    use MailerTrait;

    protected function postPost($obj, EntityManager $em)
    {
        $subject = 'Nova Cópia Final: '.$obj->getRealizacao()->getTitulo();
        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'params' => $obj->getId(),
        ), true);

        $template = $this->bundleName.':email';
        $to = 'comissaoproducaouff@gmail.com';
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-user';
        $to = $obj->getRealizacao()->getUser()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-professor';
        $to = $obj->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-equipe';
        $emailsEquipes = array();
        foreach($obj->getFichaTecnica()->getEquipes() as $equipe) {
            foreach($equipe->getUsers() as $user) {
                $emailsEquipes[] = $user->getEmail();
            }
        }
        $emailsEquipes = array_unique($emailsEquipes);
        foreach($emailsEquipes as $email) {
            $to = $email;
            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }

        $config = $em->getRepository('CineviConfigBundle:Config')->getConfig();
        $mensagem = 'Criação de cópia final realizada com sucesso!';
        if($config && $config->getMensagemCopiaFinal()) {
            $mensagem .= ' '.$config->getMensagemCopiaFinal();
        }
        $this->get('session')->getFlashBag()->set('success', $mensagem);

        return $obj;
    }

    protected function preFormPut($obj, Form $form, EntityManager $em) : Form
    {
        $this->confirmed = $obj->getConfirmado();

        return $form;
    }

    protected function postPut($obj, EntityManager $em)
    {
        if($this->confirmed == false && $obj->getConfirmado() == true) {
            $subject = 'Confirmação de Cópia Final: '.$obj->getRealizacao()->getTitulo();
            $path = $this->generateUrl('get_copias-finais', array(
                'id' => $obj->getId()
            ), true);
            $template = $this->bundleName.':email-confirmacao';
            $emailsConfirmacao = array(
                'morenoantonio.n@gmail.com',
                $obj->getRealizacao()->getUser()->getEmail()
            );
            foreach($emailsConfirmacao as $emailConfirmacao) {
                $this->sendMail($this->container, $obj, $path, $subject, $emailConfirmacao, $template);
            }
        }

        return $obj;
    }
}
