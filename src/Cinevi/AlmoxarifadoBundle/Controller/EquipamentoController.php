<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\AlmoxarifadoBundle\Entity\Equipamento;
use Cinevi\AlmoxarifadoBundle\Form\Type\EquipamentoType;

/**
 * @RouteResource("reservaveis", pluralize=false)
 */
class EquipamentoController extends RestfulCrudController implements ClassResourceInterface
{
    use MailerTrait;

    protected $bundleName = 'CineviAlmoxarifadoBundle:Equipamento';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:Equipamento';
    protected $className = Equipamento::class;
    protected $routeSuffix = 'reservaveis';
    protected $formClassName = EquipamentoType::class;
    protected $paramsKey = 'id';
    private $manutencao;
    private $atrasado;

    protected function preFormPut($obj, Form $form, EntityManager $em) : Form
    {
        $this->manutencao = $obj->getManutencao();
        $this->atrasado = $obj->getAtrasado();

        return $form;
    }

    protected function postPut($obj, EntityManager $em)
    {
        if($this->manutencao == false && $obj->getManutencao() == true) {
            $subject = 'Manutenção de Equipamento: '.$obj->getNome();
            $template = $this->bundleName.':email';
            foreach($obj->getCalendarEvents() as $reserva) {
                if($reserva->getStartDate() > new \DateTime()) {
                    $path = $this->generateUrl('get_reservas', array(
                        'params' => $reserva->getId()
                    ), true);
                    $to = $reserva->getUser()->getEmail();
                    $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
                }
            }
        }

        if($this->atrasado == false && $obj->getAtrasado() == true) {
            $subject = 'Devolução Atrasada de Equipamento: '.$obj->getNome();
            $template = $this->bundleName.':email-atrasado';
            foreach($obj->getCalendarEvents() as $reserva) {
                if($reserva->getStartDate() > new \DateTime()) {
                    $path = $this->generateUrl('get_reservas', array(
                        'params' => $reserva->getId()
                    ), true);
                    $to = $reserva->getUser()->getEmail();
                    $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
                }
            }
        }
    }
}
