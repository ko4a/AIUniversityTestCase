<?php

namespace App\MessageHandler;

use App\Message\FlightCanceledMessage;
use App\Service\MailerService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class FlightCanceledMessageHandler implements MessageHandlerInterface
{
    private MailerService $mailer;

    public function __construct(MailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(FlightCanceledMessage $message)
    {
        $this->mailer->sendFlightCanceledMail($message->getFlightId());
    }
}
