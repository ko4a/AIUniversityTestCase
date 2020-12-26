<?php

declare(strict_types=1);

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
            $key->setKey(str_repeat((string) $i, $i));
            $manager->persist($key);
        }
        $manager->flush();
    }
}
