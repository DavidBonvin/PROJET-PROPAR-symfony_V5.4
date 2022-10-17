<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    // /**
    //  * @Route("/mailer", name="app_mailer")
    //  */
    public function sendEmail(): void
    {
        $email = (new Email())
            ->from('cloudme2023@gmail.com')
            ->to('ladressetkt11@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        // ...
        // return $this->render('mailer/index.html.twig', [
        //     'controller_name' => 'MailerController',
        // ]);
    }
}
