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
    protected $routeSuffix = 'copia_final';
    protected $formClassName = CopiaFinalType::class;

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
                $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
            }
        }

        $emailsEquipes = array_unique($emailsEquipes);

        foreach($emailsEquipes as $email) {
            $destinatario = $email;
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        return $obj;
    }
}
