<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Swift_Mailer;
use Twig_Environment;
use App\Controller\Admin\AbstractCrudController;
use App\Mailer\MailerTrait;
use App\Entity\CopiaFinal;
use App\Entity\CopiaFinalHistorico;
use App\Entity\Config;
use App\Form\Realizacao\CopiaFinalType;

class CopiaFinalController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'realizacao_copia_final';
    protected $templateDir = 'realizacao/copia_final';
    protected $repositoryName = CopiaFinal::class;
    protected $historicoRepository = CopiaFinalHistorico::class;
    protected $className = CopiaFinal::class;
    protected $formClassName = CopiaFinalType::class;
    protected $paramsKey = 'id';
    private $confirmed;

    protected function postNew($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $subject = 'Nova Cópia Final: '.$obj->getRealizacao()->getTitulo();
        $path = $this->generateUrl($this->canonicalName.'_show', array(
            'params' => $obj->getId(),
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $template = $this->templateDir.'/email';
        $to = 'comissaoproducaouff@gmail.com';
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_user';
        $to = $obj->getRealizacao()->getUser()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_professor';
        $to = $obj->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

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
            $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);
        }

        if($obj->getConfirmado() == false){
            $this->changeMessage('Criação de cópia final realizada com sucesso!', $em, $session);
        }
    }

    protected function preFormEdit($obj, Form $form, EntityManagerInterface $em) : Form
    {
        $this->confirmed = $obj->getConfirmado();

        return $form;
    }

    protected function postEdit($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
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
                $this->sendMail($mailer, $twig, $obj, $path, $subject, $emailConfirmacao, $template);
            }
        }

        if($obj->getConfirmado() == false){
            $this->changeMessage('Edição de cópia final realizada com sucesso!', $em, $session);
        }
    }

    private function changeMessage($message, EntityManagerInterface $em, SessionInterface $session)
    {
        $config = $em->getRepository(Config::class)->getConfig();

        if($config && $config->getMensagemCopiaFinal()) {
            $message .= ' '.$config->getMensagemCopiaFinal();
        }

        $session->getFlashBag()->set('success', $message);
    }
}
