<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CallbackRequestDTO;
use App\Message\FlightCanceledMessage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CallbackService
{
    public const EVENTS = [
        self::FLIGHT_SALES_COMPLETED, self::FLIGHT_CANCELED,
    ];

    public const FLIGHT_SALES_COMPLETED = 'flight_ticket_sales_completed';
    public const FLIGHT_CANCELED = 'flight_canceled';

    private TranslatorInterface $translator;
    private FlightService $flightService;
    private MessageBusInterface $bus;

    public function __construct(TranslatorInterface $translator, FlightService $flightService, MessageBusInterface $bus)
    {
        $this->translator = $translator;
        $this->flightService = $flightService;
        $this->bus = $bus;
    }

    public function call(CallbackRequestDTO $dto): void
    {
        if (!in_array($dto->getEvent(), self::EVENTS, true)) {
            throw new BadRequestHttpException($this->translator->trans('event.not_registered'), null, Response::HTTP_BAD_REQUEST);
        }

        $flightId = $dto->getFlightId();

        if (self::FLIGHT_SALES_COMPLETED === $dto->getEvent()) {
            $this->flightService->completeSaling($flightId);
        } else {
            $this->bus->dispatch(new FlightCanceledMessage($flightId));
        }
    }
}
