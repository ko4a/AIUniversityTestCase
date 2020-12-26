<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ReservationCreateRequestDTO;
use App\Entity\Flight;
use App\Entity\Reservation;
use App\Exception\ValidationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReservationService
{
    private $em;
    private $validator;
    private TranslatorInterface $translator;

    public function __construct(EntityManagerInterface $em,
                                ValidatorInterface $validator,
                                TranslatorInterface $translator
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->translator = $translator;
    }

    public function delete(Reservation $reservation): void
    {
        $this->em->remove($reservation);

        $this->em->flush();
    }

    public function create(ReservationCreateRequestDTO $dto): Reservation
    {
        $flight = $this->em->find(Flight::class, $dto->getFlightId());

        if (null === $flight) {
            $msg = $this->translator->trans('flight.not_exist');
            throw new InvalidArgumentException($msg, Response::HTTP_BAD_REQUEST);
        }

        $reservation = new Reservation();
        $reservation->setFlight($flight);
        $reservation->setSeatNumber($dto->getSeat());

        return $this->save($reservation);
    }

    public function save(Reservation $reservation): Reservation
    {
        $errs = $this->validator->validate($reservation);

        if ($errs->count() > 0) {
            throw new ValidationFailedException($errs);
        }

        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }
}
