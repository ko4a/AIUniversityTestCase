<?php

namespace App\DataFixtures;

use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FlightFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $flight = new Flight();
            $this->setReference('flight'.$i, $flight);
            $manager->persist($flight);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
