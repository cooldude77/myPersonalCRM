<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $emailId = null;

    #[ORM\Column(length: 1000)]
    private ?string $password = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserTypePrefill $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailId(): ?string
    {
        return $this->emailId;
    }

    public function setEmailId(string $emailId): static
    {
        $this->emailId = $emailId;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getType(): ?UserTypePrefill
    {
        return $this->type;
    }

    public function setType(UserTypePrefill $type): static
    {
        $this->type = $type;

        return $this;
    }
}
