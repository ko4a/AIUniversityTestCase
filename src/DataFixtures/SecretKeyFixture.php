<?php

namespace App\DataFixtures;

use App\Entity\CallbackSecretKey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SecretKeyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $key = new CallbackSecretKey();
            $key->setKey(str_repeat($i, $i));
            $manager->persist($key);
        }
        $manager->flush();
    }
}
