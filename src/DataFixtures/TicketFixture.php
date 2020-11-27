<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; ++$i) {
            for ($j = 0; $j < 5; ++$j) {
                $ticket = new Reservation();
                $ticket->setFlight($this->getReference('flight'.$i));
                $ticket->setSeatNumber($j + 5);
                $manager->persist($ticket);
            }
        }
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
