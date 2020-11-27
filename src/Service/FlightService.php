<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Flight;
use App\Repository\FlightRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

class FlightService
{
    private $flightRepository;
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $translator;

    public function __construct(
        FlightRepository $flightRepository,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ) {
        $this->flightRepository = $flightRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function completeSaling(int $id): void
    {
        $flight = $this->flightRepository->find($id);

        if (null === $flight) {
            throw new BadRequestHttpException(sprintf($this->translator->trans('flight.id_not_exist'), $id), null, Response::HTTP_BAD_REQUEST);
        }

        $flight->setSalesCompleted(true);

        $this->entityManager->flush();
    }

    public function isSeatFree(Flight $flight, int $seatNumber): bool
    {
        $busySeats = array_map(fn ($x) => $x['seatNumber'],
            $this->flightRepository->findNotFreeSeats($flight)
        );

        return !in_array($seatNumber, $busySeats, true);
    }
}
