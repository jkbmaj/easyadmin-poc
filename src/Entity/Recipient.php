<?php

namespace App\Entity;

use DateTimeInterface;
use DateTimeImmutable;
use App\Repository\RecipientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipientRepository::class)]
class Recipient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\Email(
        message: 'Adres {{ value }} nie jest prawidłowym adresem e-mail',
    )]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $consentAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $verifiedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $browser = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $unsubscribedAt = null;

    #[ORM\OneToMany(mappedBy: 'recipient', targetEntity: MessageSent::class)]
    private Collection $messageSents;

    public function __construct()
    {
        $this->messageSents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getConsentAt(): ?DateTimeImmutable
    {
        return $this->consentAt;
    }

    public function setConsentAt(DateTimeImmutable $consentAt): static
    {
        $this->consentAt = $consentAt;

        return $this;
    }

    public function getVerifiedAt(): ?DateTimeImmutable
    {
        return $this->verifiedAt;
    }

/** @internal */
    public function setVerifiedAt(?DateTimeImmutable $verifiedAt): void
    {
        $this->verifiedAt = $verifiedAt;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    public function setBrowser(string $browser): static
    {
        $this->browser = $browser;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function generateToken(): static
    {
        $this->token = sha1(
            date('Ymd') . $this->email . random_int(1, 100000)
        );

        return $this;
    }

    public function confirm(): static
    {
        $this->verifiedAt = new DateTimeImmutable();

        return $this;
    }

    public function getUnsubscribedAt(): ?DateTimeInterface
    {
        return $this->unsubscribedAt;
    }

    public function setUnsubscribedAt(?DateTimeInterface $unsubscribedAt): static
    {
        $this->unsubscribedAt = $unsubscribedAt;

        return $this;
    }

    /**
     * @return Collection<int, MessageSent>
     */
    public function getMessageSents(): Collection
    {
        return $this->messageSents;
    }

    public function addMessageSent(MessageSent $messageSent): static
    {
        if (!$this->messageSents->contains($messageSent)) {
            $this->messageSents->add($messageSent);
            $messageSent->setRecipient($this);
        }

        return $this;
    }

    public function removeMessageSent(MessageSent $messageSent): static
    {
        if ($this->messageSents->removeElement($messageSent)) {
            // set the owning side to null (unless already changed)
            if ($messageSent->getRecipient() === $this) {
                $messageSent->setRecipient(null);
            }
        }

        return $this;
    }
}
