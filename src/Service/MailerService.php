<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Twig\Environment;

class MailerService
{
    private $mailer;

    public function __construct(TransportInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $to): void
    {
        $email = (new Email())
            ->from(new Address('cloudme2023@gmail.com', 'Propar'))
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Propar: Votre nettoyage est terminé !')
            ->html("<p>Bonjour<br><br>
            Votre facture est disponible ci-joint !<br><br>
            Propar vous remercie pour votre confiance !</p>")
            // ->text(fopen("/Users/mohirmehhat/Workspace/PHP/PROPAR/templates/pdf/textEmail.txt", "r"))
            ->attachFromPath('/Users/mohirmehhat/Workspace/PHP/PROPAR/public/pdf/facture.pdf');
        // ->attachFromPath('/Users/mohirmehhat/Workspace/PHP/PROPAR/public/pdf/facture.pdf');
        $this->mailer->send($email);
    }
}
