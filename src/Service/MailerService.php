<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendFlightCanceledMail(int $id): void
    {
        $mail = (new Email())
                ->from('slavakochnevcase@gmail.com')
                ->to('slavakochnevcase@gmail.com')
                ->subject('Send email from rabbitmq')
                ->text('Send email from rabbitmq')
            ;

        $this->mailer->send($mail);
    }
}
