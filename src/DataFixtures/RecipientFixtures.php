<?php

declare(strict_types=1);

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
                ->setName('John Doe' . random_int(0, 10000))
                ->setIp('127.0.0.1')
                ->setBrowser('Chrome')
                ->setSource('referer')
                ->generateToken();

            if (0 === $i % 3) {
                $recipient->confirm();
            }

            $manager->persist($recipient);
        }

        $manager->flush();
    }
}
