<?php

namespace Cinevi\RealizacaoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\RealizacaoBundle\Entity\CopiaFinal;
use Cinevi\RealizacaoBundle\Form\Type\CopiaFinalType;

class CopiaFinalController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviRealizacaoBundle:CopiaFinal';
    protected $repositoryName = 'CineviRealizacaoBundle:CopiaFinal';
    protected $className = CopiaFinal::class;
    protected $routeSuffix = 'copiaFinal';
    protected $label = 'copiaFinal';
    protected $formClassName = CopiaFinalType::class;

    protected function posCriar($obj, EntityManager $em)
    {
        $template = $this->bundleName.':email';

        $assunto = 'Nova Cópia Final: '.$obj->getNome();

        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'id' => $obj->getId(),
        ), true);

        // Envia email para os emails no array
        $emails = array(
            $obj->getUser()->getEmail(),
            'cinevi@vm.uff.br',
            'comissaoproducaouff@gmail.com'
        );

        foreach($emails as $email) {
            $destinatario = $email;
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        return $obj;
    }
}