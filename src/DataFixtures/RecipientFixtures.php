<?php

namespace App\DataFixtures;

use App\Entity\Recipient;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $recipient = (new Recipient())
                ->setConsentAt(new DateTimeImmutable())
                ->setEmail('user' . $i . '@example.com')
                ->setName('John Doe' . random_int(0,10000))
                ->setIp('127.0.0.1')
                ->setBrowser('Chrome')
                ->setSource('referer')
                ->generateToken();

            if ($i % 3 === 0) {
                $recipient->confirm();
            }

            $manager->persist($recipient);
        }

        $manager->flush();
    }
}
