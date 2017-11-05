<?php

namespace Cinevi\AdminBundle\Mailer;

use Symfony\Component\DependencyInjection\ContainerInterface;

trait MailerTrait
{
    public function sendMail(ContainerInterface $container, $obj, $path, $subject, $to, $template)
    {
        $remetente = 'contato@cinemauff.com.br';

        // HTML
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($remetente)
            ->setTo($to)
            ->setBody(
                $container->get('twig')->render(
                    $template.'.html.twig',
                    array(
                        'item' => $obj,
                        'url' => $path,
                        'subject' => $subject,
                        'to' => $to,
                    )
                ),
                'text/html'
            )
            ->addPart(
                $container->get('twig')->render(
                    $template.'.txt.twig',
                    array(
                        'item' => $obj,
                        'url' => $path,
                        'subject' => $subject,
                        'to' => $to,
                    )
                ),
                'text/plain'
            )
        ;

        $container->get('mailer')->send($message);
    }
}
