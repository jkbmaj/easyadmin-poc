<?php

namespace App\EventSubscriber;

use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewsletterSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => [
                ['setCreatedBy'],
            ],
        ];
    }

    public function setCreatedBy(BeforeEntityPersistedEvent $beforeEntityPersistedEvent): void
    {
        $entity = $beforeEntityPersistedEvent->getEntityInstance();

        if (!$entity instanceof Newsletter) {
            return;
        }

        $entity->setCreatedBy($this->security->getUser());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
