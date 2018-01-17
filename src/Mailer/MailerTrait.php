<?php

namespace App\Mailer;

use Swift_Mailer;
use Twig_Environment;

trait MailerTrait
{
    public function sendMail(Swift_Mailer $mailer, Twig_Environment $twig, $obj, $path, $subject, $to, $template)
    {
        $remetente = 'contato@cinemauff.com.br';

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($remetente)
            ->setTo($to)
            ->setBody(
                $twig->render(
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
                $twig->render(
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

        $mailer->send($message);
    }
}
