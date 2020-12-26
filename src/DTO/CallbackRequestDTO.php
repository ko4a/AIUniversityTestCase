<?php

declare(strict_types=1);

namespace App\DTO;

class CallbackRequestDTO
{
    private int $flightId;
    private int $triggeredAt;
    private string $event;
    private string $secretKey;

    public function __construct(array $params)
    {
        $data = $params['data'];

        $this->flightId = $data['flight_id'];
        $this->triggeredAt = $data['triggered_at'];
        $this->event = $data['event'];
        $this->secretKey = $data['secret_key'];
    }

    public function getFlightId(): int
    {
        return $this->flightId;
    }

    public function getTriggeredAt(): int
    {
        return $this->triggeredAt;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }
}
