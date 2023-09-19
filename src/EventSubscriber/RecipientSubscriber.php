<?php

namespace App\EventSubscriber;

use App\Entity\Recipient;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RecipientSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => [
                ['generateToken'],
            ],
        ];
    }

    public function generateToken(BeforeEntityPersistedEvent $beforeEntityPersistedEvent): void
    {
        $entity = $beforeEntityPersistedEvent->getEntityInstance();

        if (!$entity instanceof Recipient) {
            return;
        }

        $entity->generateToken();
    }
}
