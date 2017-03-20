<?php

namespace Cinevi\AlmoxarifadoBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Cinevi\AdminBundle\Command\BaseCommand;
use Cinevi\AdminBundle\Mailer\MailerTrait;

class CalendarEventCommand extends BaseCommand
{
    use MailerTrait;

    protected $name = 'checa:reservas';
    protected $description = 'Checa se o dia atual é o dia de retirada ou devolução de alguma reserva.';
    protected $help = 'Este comando checa reserva a reserva se a data de retirada ou a data de devolução bate com o dia atual.';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $reservas = $em->getRepository('CineviAlmoxarifadoBundle:CalendarEvent')->findAll();

        $hoje = new \DateTime();
        $hoje->setTime( 0, 0, 0 );

        foreach($reservas as $reserva) {

            $diffStartDate = $hoje->diff($reserva->getStartDate());
            $intervalStartDate = (int)$diffStartDate->format("%r%a");

            // Manda email: um dia antes de retirada
            if($intervalStartDate == -1) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada-user-antes';

                $assunto = 'Retirada de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = 'almoxarifadocinemauff@gmail.com';

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                // Email para o usuário
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada-user-antes';

                $assunto = 'Retirada de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = $reserva->getUser()->getEmail();

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                $output->writeln('Foram enviados emails avisando de retiradas amanhã.');
            }

            // Manda email: dia de retirada
            if($intervalStartDate == 0) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada';

                $assunto = 'Retirada de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = 'almoxarifadocinemauff@gmail.com';

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                // Email para o usuário
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada-user';

                $assunto = 'Retirada de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = $reserva->getUser()->getEmail();

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                $output->writeln('Foram enviados emails avisando de retiradas hoje.');
            }

            $diffEndDate = $hoje->diff($reserva->getEndDate());
            $intervalEndDate = (int)$diffEndDate->format("%r%a");

            // Manda email: dia de devolução
            if($intervalEndDate == 0) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao';

                $assunto = 'Devolução de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = 'almoxarifadocinemauff@gmail.com';

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                // Email para o usuário
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao-user';

                $assunto = 'Devolução de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = $reserva->getUser()->getEmail();

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                $output->writeln('Foram enviados emails avisando de devoluções hoje.');
            }

            if($intervalEndDate == 1) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao-depois';

                $assunto = 'Devolução de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = 'almoxarifadocinemauff@gmail.com';

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                // Email para o usuário
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao-user-depois';

                $assunto = 'Devolução de Equipamento(s): '.$reserva->getTitle();

                $path = $this->getContainer()->get('router')->generate('get_calendar_event', array(
                    'id' => $reserva->getId(),
                ), true);

                $destinatario = $reserva->getUser()->getEmail();

                $this->sendMail($this->getContainer(), $reserva, $path, $assunto, $destinatario, $template);

                $output->writeln('Foram enviados emails avisando de devoluções ontem.');
            }

            $output->writeln('Comando executado com sucesso.');
        }
    }
}
