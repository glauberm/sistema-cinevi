<?php

namespace AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use AdminBundle\Controller\AbstractCrudController;
use AdminBundle\Mailer\MailerTrait;
use AlmoxarifadoBundle\Entity\Equipamento;
use AlmoxarifadoBundle\Form\EquipamentoType;

class EquipamentoController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'almoxarifado_equipamento';
    protected $bundleName = 'AlmoxarifadoBundle:Equipamento';
    protected $repositoryName = 'AlmoxarifadoBundle:Equipamento';
    protected $className = Equipamento::class;
    protected $formClassName = EquipamentoType::class;
    protected $paramsKey = 'id';
    private $manutencao;
    private $atrasado;

    protected function preShow(Request $request, EntityManager $em, $obj, array $data = []) : array
    {
        $r = $em->getRepository('AlmoxarifadoBundle:CalendarEvent');

        $qb = $r->list($this->get('security.authorization_checker'), 'reserva');

        $qb = $r->listWhereEquipamentoIs($qb, $obj->getId(), 'reserva');

        $pagination = $this->createPagination($request, $this->get('knp_paginator'), $qb);

        $data['pagination'] = $pagination;

        return $data;
    }

    protected function preFormEdit($obj, Form $form, EntityManager $em) : Form
    {
        $this->manutencao = $obj->getManutencao();
        $this->atrasado = $obj->getAtrasado();

        return $form;
    }

    protected function postEdit($obj, EntityManager $em)
    {
        if($this->manutencao == false && $obj->getManutencao() == true) {
            $subject = 'Manutenção de Equipamento: '.$obj->getNome();
            $template = $this->bundleName.':email';
            foreach($obj->getCalendarEvents() as $reserva) {
                if($reserva->getStartDate() > new \DateTime()) {
                    $path = $this->generateUrl('almoxarifado_reserva_show', array(
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
                    $path = $this->generateUrl('almoxarifado_reserva_show', array(
                        'params' => $reserva->getId()
                    ), true);
                    $to = $reserva->getUser()->getEmail();
                    $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
                }
            }
        }
    }
}
