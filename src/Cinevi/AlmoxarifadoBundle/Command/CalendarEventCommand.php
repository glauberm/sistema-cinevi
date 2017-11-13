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

        $hoje = new \DateTime();
        $hoje->setTime( 0, 0, 0 );

        $reservas = $em
            ->getRepository('CineviAlmoxarifadoBundle:CalendarEvent')
            ->findAllBetweenDates($hoje, $hoje)
            ->getQuery()->getResult()
        ;

        foreach($reservas as $reserva) {

            $diffStartDate = $hoje->diff($reserva->getStartDate());
            $intervalStartDate = (int)$diffStartDate->format("%r%a");

            if($intervalStartDate == 0) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);

                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada-user';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);

                $output->writeln('Foram enviados emails avisando sobre a retirada da reserva '.$reserva->getTitle().' hoje.');
            }

            if($intervalStartDate == 1) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada-user-antes';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);

                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-retirada-user-antes';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);
                $output->writeln('Foram enviados emails avisando sobre a retirada da reserva '.$reserva->getTitle().' amanhã.');
            }

            $diffEndDate = $hoje->diff($reserva->getEndDate());
            $intervalEndDate = (int)$diffEndDate->format("%r%a");

            if($intervalEndDate == 0) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);

                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao-user';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);
                $output->writeln('Foram enviados emails avisando sobre a devolução da reserva '.$reserva->getTitle().' hoje.');
            }

            if($intervalEndDate == 1) {
                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao-antes';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);

                $template = 'CineviAlmoxarifadoBundle:CalendarEvent:email-devolucao-user-antes';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->getContainer()->get('router')->generate('get_reservas', array(
                    'params' => $reserva->getId(),
                ), true);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->getContainer(), $reserva, $path, $subject, $to, $template);
                $output->writeln('Foram enviados emails avisando sobre a devolução da reserva '.$reserva->getTitle().' amanhã.');
            }
        }

        $output->writeln('Fim do comando. Se nenhuma mensagem apareceu antes dessa, nenhum email será disparado.');
    }
}
