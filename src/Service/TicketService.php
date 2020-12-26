<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\TicketCreateRequestDTO;
use App\Entity\Flight;
use App\Entity\Ticket;
use App\Exception\ValidationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TicketService
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

    public function create(TicketCreateRequestDTO $dto): Ticket
    {
        $flight = $this->em->find(Flight::class, $dto->getFlightId());

        if (null === $flight) {
            $msg = $this->translator->trans('flight.not_exist');
            throw new InvalidArgumentException($msg, Response::HTTP_BAD_REQUEST);
        }

        $ticket = new Ticket();

        $ticket->setSeatNumber($dto->getSeat());
        $ticket->setFlight($flight);

        return $this->save($ticket);
    }

    public function save(Ticket $ticket): Ticket
    {
        $errs = $this->validator->validate($ticket);

        if ($errs->count() > 0) {
            throw new ValidationFailedException($errs);
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
