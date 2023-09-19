<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    /** @var string[] */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: NewsletterTemplate::class)]
    private Collection $newsletterTemplates;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Newsletter::class)]
    private Collection $newsletters;

    public function __construct()
    {
        $this->newsletterTemplates = new ArrayCollection();
        $this->newsletters = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->username ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /** @param string[] $roles */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @return Collection<int, NewsletterTemplate>
     */
    public function getNewsletterTemplates(): Collection
    {
        return $this->newsletterTemplates;
    }

    public function addNewsletterTemplate(NewsletterTemplate $newsletterTemplate): static
    {
        if (!$this->newsletterTemplates->contains($newsletterTemplate)) {
            $this->newsletterTemplates->add($newsletterTemplate);
            $newsletterTemplate->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNewsletterTemplate(NewsletterTemplate $newsletterTemplate): static
    {
        // set the owning side to null (unless already changed)
        if (!$this->newsletterTemplates->removeElement($newsletterTemplate)) {
            return $this;
        }

        if ($newsletterTemplate->getCreatedBy() !== $this) {
            return $this;
        }

        $newsletterTemplate->setCreatedBy(null);

        return $this;
    }

    /**
     * @return Collection<int, Newsletter>
     */
    public function getNewsletters(): Collection
    {
        return $this->newsletters;
    }

    public function addNewsletter(Newsletter $newsletter): static
    {
        if (!$this->newsletters->contains($newsletter)) {
            $this->newsletters->add($newsletter);
            $newsletter->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNewsletter(Newsletter $newsletter): static
    {
        // set the owning side to null (unless already changed)
        if (!$this->newsletters->removeElement($newsletter)) {
            return $this;
        }

        if ($newsletter->getCreatedBy() !== $this) {
            return $this;
        }

        $newsletter->setCreatedBy(null);
        return $this;
    }
}
