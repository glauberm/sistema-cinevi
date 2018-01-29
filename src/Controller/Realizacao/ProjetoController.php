<?php

namespace App\Controller\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Swift_Mailer;
use Twig_Environment;
use App\Controller\Admin\AbstractCrudController;
use App\Mailer\MailerTrait;
use App\Entity\Projeto;
use App\Entity\ProjetoHistorico;
use App\Form\Realizacao\ProjetoType;

class ProjetoController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'realizacao_projeto';
    protected $templateDir = 'realizacao/projeto';
    protected $repositoryName = Projeto::class;
    protected $historicoRepository = ProjetoHistorico::class;
    protected $className = Projeto::class;
    protected $formClassName = ProjetoType::class;
    protected $paramsKey = 'id';

    protected function postFormNew(Form $form, EntityManagerInterface $em, AuthorizationCheckerInterface $ac) : Form
    {
        $form = $this->checkCopiaFinal($form, $ac);

        return $form;
    }

    protected function postFormEdit($obj, Form $form, EntityManagerInterface $em, AuthorizationCheckerInterface $ac) : Form
    {
        $form = $this->checkCopiaFinal($form, $ac, $obj);

        return $form;
    }

    protected function postNew($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
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
            $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);
        }

        $template = $this->templateDir.'/email_user';
        $to = $obj->getRealizacao()->getUser()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_professor';
        $to = $obj->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

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
            $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);
        }
    }

    private function checkCopiaFinal(Form $form, AuthorizationCheckerInterface $ac, $obj = null)
    {
        $user = $form->get('realizacao')->get('user')->getData();

        if(!empty($user) && ($user->getProfessor() !== true || $ac->isGranted('ROLE_DEPARTAMENTO'))) {
            $projetosArray = array();
            foreach($user->getRealizacaos() as $realizacao) {
                if($realizacao->getProjeto() && $realizacao->getProjeto() instanceof $this->className) {
                    $projetosArray[] = $realizacao->getProjeto();
                }
            }

            foreach($projetosArray as $projeto) {
                if($projeto != $obj && !$projeto->getCopiaFinal()) {
                    $message = 'Para registrar um novo projeto com este responsável, é preciso registrar a cópia final do seu projeto '.$projeto->getRealizacao()->getTitulo().'.';
                    $form->get('realizacao')->get('user')->addError(new FormError($message));
                }
            }
        }

        return $form;
    }
}
