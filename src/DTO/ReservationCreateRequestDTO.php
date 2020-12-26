<?php

declare(strict_types=1);

namespace App\DTO;

class ReservationCreateRequestDTO
{
    private int $seat;
    private int $flightId;

    public function __construct(array $params)
    {
        $this->seat = $params['seat'];
        $this->flightId = $params['flight_id'];
    }

    public function getSeat(): int
    {
        return $this->seat;
    }

    public function getFlightId(): int
    {
        return $this->flightId;
    }
}
