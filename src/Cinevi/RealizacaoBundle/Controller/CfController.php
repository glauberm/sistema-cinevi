<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\RealizacaoBundle\Entity\CopiaFinal;
use Cinevi\RealizacaoBundle\Form\Type\CopiaFinalType;

class CfController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviRealizacaoBundle:CopiaFinal';
    protected $repositoryName = 'CineviRealizacaoBundle:CopiaFinal';
    protected $className = CopiaFinal::class;
    protected $routeSuffix = 'cf';
    protected $formClassName = CopiaFinalType::class;

    private $confirmado;

    protected function listar($builder, EntityManager $em)
    {
        return $builder->join('item.realizacao', 'r');
    }

    protected function posPersist($obj, EntityManager $em)
    {
        $template = $this->bundleName.':email';

        $assunto = 'Nova Cópia Final: '.$obj->getRealizacao()->getTitulo();

        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'id' => $obj->getId(),
        ), true);

        // Envia email para os emails no array
        $emails = array(
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

        foreach($obj->getFichaTecnica()->getEquipes() as $equipe) {
            foreach($equipe->getUsers() as $user) {
                $emailsEquipes[] = $user->getEmail();
            }
        }

        $emailsEquipes = array_unique($emailsEquipes);

        foreach($emailsEquipes as $email) {
            $destinatario = $email;
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        // Pega se tem mensagem no config para adicionar à mensagem.
        $configuration = $this->getConfiguration($em);

        $mensagem = 'Criação de cópia final realizada com sucesso!';

        if($configuration->getMensagemCopiaFinal()) {
            $mensagem .= ' '.$configuration->getMensagemCopiaFinal();
        }

        // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
        $this->get('session')->getFlashBag()->set('success', $mensagem);

        /*$this->get('session')->getFlashBag()->set('success', 'Criação de cópia final realizada com sucesso! Para finalizar o processo você deve se encontrar com o Cláudio (disponível na Sala Zeca Porto, de 8h às 14h), que pode ser contactado pelo e-mail claudio.ciambelli@gmail.com. Você deve entregá-lo um arquivo da versão final do filme, obrigatoriamente no formato: MPEG4 H264. Deverá entregá-lo também uma cópia de visionamento, no formato MOV.
        Assim que o processo for finalizado você receberá um email de confirmação e poderá voltar a cadastrar projetos.');*/

        return $obj;
    }

    protected function preEditar($obj, Form $form, EntityManager $em)
    {
        $this->confirmado = $obj->getConfirmado();

        return $form;
    }

    protected function posMerge($obj, EntityManager $em)
    {
        if($this->confirmado == false && $obj->getConfirmado() == true) {
            $template = $this->bundleName.':email-confirmacao';

            $assunto = 'Confirmação de Cópia Final: '.$obj->getRealizacao()->getTitulo();

            $path = $this->generateUrl('get_cf', array(
                'id' => $obj->getId()
            ), true);

            $emailsConfirmacao = array(
                'morenoantonio.n@gmail.com',
                $obj->getRealizacao()->getUser()->getEmail()
            );

            foreach($emailsConfirmacao as $emailConfirmacao) {
                $this->sendMail($this->container, $obj, $path, $assunto, $emailConfirmacao, $template);
            }
        }

        return $obj;
    }
}
