<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Flight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Flight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flight[]    findAll()
 * @method Flight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flight::class);
    }

    public function findNotFreeSeats(Flight $flight): array
    {
        $busyByTickets = $this->findSeatsBusyByTickets($flight);
        $busyByBooking = $this->findSeatsBusyByReservations($flight);

        return array_merge($busyByTickets, $busyByBooking);
    }

    public function findSeatsBusyByTickets(Flight $flight): array
    {
        $qb = $this->createQueryBuilder('f');

        return $qb
            ->select('ft.seatNumber')
            ->andWhere('f.id =:id')
            ->setParameter('id', $flight->getId())
            ->leftJoin('f.tickets', 'ft')
            ->getQuery()
            ->getArrayResult();
    }

    public function findSeatsBusyByReservations(Flight $flight): array
    {
        $qb = $this->createQueryBuilder('f');

        return $qb
            ->select('fr.seatNumber')
            ->andWhere('f.id =:id')
            ->setParameter('id', $flight->getId())
            ->leftJoin('f.reservations', 'fr')
            ->getQuery()
            ->getArrayResult();
    }
}
