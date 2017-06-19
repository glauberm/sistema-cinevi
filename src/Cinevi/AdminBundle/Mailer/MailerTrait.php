<?php

namespace Cinevi\AdminBundle\Mailer;

use Symfony\Component\DependencyInjection\ContainerInterface;

trait MailerTrait
{
    public function sendMail(ContainerInterface $container, $obj, $path, $assunto, $destinatario, $template)
    {
        $remetente = 'contato@cinemauff.com.br';

        // HTML
        $message = \Swift_Message::newInstance()
            ->setSubject($assunto)
            ->setFrom($remetente)
            ->setTo($destinatario)
            ->setBody(
                $container->get('twig')->render(
                    $template.'.html.twig',
                    array(
                        'item' => $obj,
                        'url' => $path,
                        'assunto' => $assunto,
                        'destinatario' => $destinatario,
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
                        'assunto' => $assunto,
                        'destinatario' => $destinatario,
                    )
                ),
                'text/plain'
            )
        ;

        $container->get('mailer')->send($message);
    }
}
