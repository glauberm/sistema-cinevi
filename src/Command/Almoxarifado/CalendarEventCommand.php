<?php

namespace App\Command\Almoxarifado;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Swift_Mailer;
use Twig_Environment;
use App\Mailer\MailerTrait;
use App\Entity\CalendarEvent;

class CalendarEventCommand extends Command
{
    use MailerTrait;

    private $em;
    private $router;
    private $mailer;
    private $twig;

    public function __construct(EntityManagerInterface $em, RouterInterface $router, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $this->em = $em;
        $this->router = $router;
        $this->mailer = $mailer;
        $this->twig = $twig;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('checa:reservas')
            ->setDescription('Checa se o dia atual é o dia de retirada ou devolução de alguma reserva.')
            ->setHelp('Este comando checa reserva a reserva se a data de retirada ou a data de devolução bate com o dia atual.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hojeComeco = new \DateTime();
        $hojeFim = new \DateTime();
        $hojeComeco->setTime( 0, 0, 0 );
        $hojeFim->setTime( 23, 59, 59 );

        $reservas = $this->em
            ->getRepository(CalendarEvent::class)
            ->findAllBetweenDates($hojeComeco, $hojeFim)
            ->getQuery()->getResult()
        ;

        foreach($reservas as $reserva) {

            $diffStartDate = $hojeComeco->diff($reserva->getStartDate());
            $intervalStartDate = (int)$diffStartDate->format("%r%a");

            if($intervalStartDate == 0) {
                $template = 'almoxarifado/calendar_event/email_retirada';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);

                $template = 'almoxarifado/calendar_event/email_retirada_user';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);

                $output->writeln('Serão enviados emails avisando sobre a retirada da reserva '.$reserva->getTitle().' hoje.');
            }

            if($intervalStartDate == 1) {
                $template = 'almoxarifado/calendar_event/email_retirada_user_antes';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);

                $template = 'almoxarifado/calendar_event/email_retirada_user_antes';
                $subject = 'Retirada de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);
                $output->writeln('Serão enviados emails avisando sobre a retirada da reserva '.$reserva->getTitle().' amanhã.');
            }

            $diffEndDate = $hojeComeco->diff($reserva->getEndDate());
            $intervalEndDate = (int)$diffEndDate->format("%r%a");

            if($intervalEndDate == 0) {
                $template = 'almoxarifado/calendar_event/email_devolucao';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);

                $template = 'almoxarifado/calendar_event/email_devolucao_user';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);
                $output->writeln('Serão enviados emails avisando sobre a devolução da reserva '.$reserva->getTitle().' hoje.');
            }

            if($intervalEndDate == 1) {
                $template = 'almoxarifado/calendar_event/email_devolucao_antes';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = 'almoxarifadocinemauff@gmail.com';
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);

                $template = 'almoxarifado/calendar_event/email_devolucao_user_antes';
                $subject = 'Devolução de Reserváveis: '.$reserva->getTitle();
                $path = $this->router->generate('almoxarifado_reserva_show', array(
                    'params' => $reserva->getId(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
                $to = $reserva->getUser()->getEmail();
                $this->sendMail($this->mailer, $this->twig, $reserva, $path, $subject, $to, $template);
                $output->writeln('Serão enviados emails avisando sobre a devolução da reserva '.$reserva->getTitle().' amanhã.');
            }
        }

        $output->writeln('Fim do comando. Se nenhuma mensagem apareceu antes dessa, nenhum email será disparado.');
    }
}
