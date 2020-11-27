<?php

namespace App\Service;

use App\Entity\Flight;
use App\Entity\Ticket;
use App\Exception\ValidationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TicketService
{
    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    public function create(array $params): Ticket
    {
        $flight = $this->em->find(Flight::class, $params['flight_id']);

        $ticket = new Ticket();

        $ticket->setSeatNumber($params['seat']);
        $ticket->setFlight($flight);

        return $this->save($ticket);
    }

    public function save(Ticket $ticket): Ticket
    {
        $errs = $this->validator->validate($ticket);

        if ($errs->count() > 0) {
            throw  new ValidationFailedException($errs);
        }

        $this->em->persist($ticket);
        $this->em->flush();

        return $ticket;
    }

    public function delete(Ticket $ticket): void
    {
        $this->em->remove($ticket);

        $this->em->flush();
    }
}
