<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Controller\Admin\AbstractCrudController;
use App\Mailer\MailerTrait;
use App\Entity\CopiaFinal;
use App\Form\Realizacao\CopiaFinalType;

class CopiaFinalController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'realizacao_copia_final';
    protected $templateDir = 'realizacao/copia_final';
    protected $repositoryName = 'App\Entity\CopiaFinal';
    protected $className = CopiaFinal::class;
    protected $formClassName = CopiaFinalType::class;
    protected $paramsKey = 'id';
    private $confirmed;

    protected function postNew($obj, EntityManager $em)
    {
        $subject = 'Nova Cópia Final: '.$obj->getRealizacao()->getTitulo();
        $path = $this->generateUrl($this->canonicalName.'_show', array(
            'params' => $obj->getId(),
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $template = $this->templateDir.'/email';
        $to = 'comissaoproducaouff@gmail.com';
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_user';
        $to = $obj->getRealizacao()->getUser()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_professor';
        $to = $obj->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_equipe';
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

        if($obj->getConfirmado() == false){
            $this->changeMessage('Criação de cópia final realizada com sucesso!', $em);
        }
    }

    protected function preFormEdit($obj, Form $form, EntityManager $em) : Form
    {
        $this->confirmed = $obj->getConfirmado();

        return $form;
    }

    protected function postEdit($obj, EntityManager $em)
    {
        if($this->confirmed == false && $obj->getConfirmado() == true) {
            $subject = 'Confirmação de Cópia Final: '.$obj->getRealizacao()->getTitulo();
            $path = $this->generateUrl('realizacao_copia_final_show', array(
                'params' => $obj->getId()
            ), UrlGeneratorInterface::ABSOLUTE_URL);
            $template = $this->templateDir.'/email_confirmacao';
            $emailsConfirmacao = array(
                'morenoantonio.n@gmail.com',
                $obj->getRealizacao()->getUser()->getEmail()
            );
            foreach($emailsConfirmacao as $emailConfirmacao) {
                $this->sendMail($this->container, $obj, $path, $subject, $emailConfirmacao, $template);
            }
        }

        if($obj->getConfirmado() == false){
            $this->changeMessage('Edição de cópia final realizada com sucesso!', $em);
        }
    }

    private function changeMessage($message, EntityManager $em)
    {
        $config = $em->getRepository('App\Entity\Config')->getConfig();

        if($config && $config->getMensagemCopiaFinal()) {
            $message .= ' '.$config->getMensagemCopiaFinal();
        }

        $this->get('session')->getFlashBag()->set('success', $message);
    }
}
