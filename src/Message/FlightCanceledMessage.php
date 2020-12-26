<?php

declare(strict_types=1);

namespace App\Message;

final class FlightCanceledMessage
{
    private int $flightId;

    public function __construct(int $flightId)
    {
        $this->flightId = $flightId;
    }

    public function getFlightId(): int
    {
        return $this->flightId;
    }

    public function setFlightId(int $flightId): FlightCanceledMessage
    {
        $this->flightId = $flightId;

        return $this;
    }
}
