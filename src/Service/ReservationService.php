<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Flight;
use App\Entity\Reservation;
use App\Exception\ValidationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReservationService
{
    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    public function delete(Reservation $reservation): void
    {
        $this->em->remove($reservation);

        $this->em->flush();
    }

    public function create(array $params): Reservation
    {
        $flight = $this->em->find(Flight::class, $params['flight_id']);

        $reservation = new Reservation();
        $reservation->setFlight($flight);
        $reservation->setSeatNumber($params['seat']);

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
