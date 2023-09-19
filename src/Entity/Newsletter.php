<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
class Newsletter implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isSent = false;

    #[ORM\ManyToOne(inversedBy: 'newsletters')]
    private ?NewsletterTemplate $template = null;

    #[ORM\ManyToOne(inversedBy: 'newsletters')]
    private ?User $createdBy = null;

    #[ORM\OneToMany(mappedBy: 'newsletter', targetEntity: MessageSent::class)]
    private Collection $messageSents;

    public function __construct()
    {
        $this->messageSents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function isIsSent(): ?bool
    {
        return $this->isSent;
    }

    public function setIsSent(bool $isSent): static
    {
        $this->isSent = $isSent;

        return $this;
    }

    public function getTemplate(): ?NewsletterTemplate
    {
        return $this->template;
    }

    public function setTemplate(?NewsletterTemplate $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

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
            $messageSent->setNewsletter($this);
        }

        return $this;
    }

    public function removeMessageSent(MessageSent $messageSent): static
    {
        if ($this->messageSents->removeElement($messageSent)) {
            // set the owning side to null (unless already changed)
            if ($messageSent->getNewsletter() === $this) {
                $messageSent->setNewsletter(null);
            }
        }

        return $this;
    }
}
