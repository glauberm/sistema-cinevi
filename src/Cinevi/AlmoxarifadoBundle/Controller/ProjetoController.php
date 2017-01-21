<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\AlmoxarifadoBundle\Entity\Projeto;
use Cinevi\AlmoxarifadoBundle\Form\Type\ProjetoType;

class ProjetoController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviAlmoxarifadoBundle:Projeto';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:Projeto';
    protected $className = Projeto::class;
    protected $routeSuffix = 'projeto';
    protected $label = 'projeto';
    protected $formClassName = ProjetoType::class;

    protected function posCriar($obj, EntityManager $em)
    {
        $template = $this->bundleName.':email';

        $assunto = 'Novo Projeto: '.$obj->getNome();

        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'id' => $obj->getId(),
        ), true);

        // Envia email para os emails no array
        $emails = array(
            $obj->getUser()->getEmail(),
            'cinevi@vm.uff.br',
            'almoxarifadocinemauff@gmail.com',
            'acervodearteuff@gmail.com',
            'comissaoproducaouff@gmail.com'
        );

        foreach($emails as $email) {
            $destinatario = $email;
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        return $obj;
    }
}
