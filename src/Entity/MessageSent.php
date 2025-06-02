<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MessageSentRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Entity(repositoryClass: MessageSentRepository::class, readOnly: true)]
class MessageSent implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $messageId = null;

    #[ORM\ManyToOne(inversedBy: 'messageSents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Newsletter $newsletter = null;

    #[ORM\ManyToOne(inversedBy: 'messageSents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipient $recipient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function setMessageId(string $messageId): static
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getNewsletter(): ?Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(?Newsletter $newsletter): static
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getRecipient(): ?Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(?Recipient $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }
}
