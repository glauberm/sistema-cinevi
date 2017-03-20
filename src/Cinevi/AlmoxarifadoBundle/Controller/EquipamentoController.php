<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\AlmoxarifadoBundle\Entity\Equipamento;
use Cinevi\AlmoxarifadoBundle\Form\Type\EquipamentoType;

class EquipamentoController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviAlmoxarifadoBundle:Equipamento';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:Equipamento';
    protected $className = Equipamento::class;
    protected $routeSuffix = 'equipamento';
    protected $formClassName = EquipamentoType::class;

    private $manutencao;

    protected function listar($builder, EntityManager $em)
    {
        return $builder->join('item.categoria', 'c');
    }

    protected function preEditar($obj, Form $form, EntityManager $em)
    {
        $this->manutencao = $obj->getManutencao();

        return $form;
    }

    protected function posMerge($obj, EntityManager $em)
    {
        if($this->manutencao == false && $obj->getManutencao() == true) {
            $template = $this->bundleName.':email';

            $assunto = 'Manutenção de Equipamento: '.$obj->getNome();

            foreach($obj->getCalendarEvents() as $reserva) {
                if($reserva->getStartDate() > new \DateTime()) {
                    $path = $this->generateUrl('get_calendar_event', array(
                        'id' => $reserva->getId()
                    ), true);

                    $destinatario = $reserva->getUser()->getEmail();

                    $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
                }
            }
        }

        return $obj;
    }
}
