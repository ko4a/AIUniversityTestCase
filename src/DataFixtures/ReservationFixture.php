<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            for ($j = 0; $j < 5; ++$j) {
                $ticket = new Ticket();
                $ticket->setFlight($this->getReference('flight'.$i));
                $ticket->setSeatNumber($j);
                $manager->persist($ticket);
            }
        }
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
