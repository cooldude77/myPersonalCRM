<?php

namespace App\Entity;

use App\Repository\OrderAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderAddressRepository::class)]
class OrderAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderHeader $orderHeader = null;

    #[ORM\Column(length: 255)]
    private ?string $line1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $line2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $line3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pinCode = null;

    #[ORM\Column(length: 255)]
    private ?string $addressType = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(?string $line1): void
    {
        $this->line1 = $line1;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): void
    {
        $this->line2 = $line2;
    }

    public function getLine3(): ?string
    {
        return $this->line3;
    }

    public function setLine3(?string $line3): void
    {
        $this->line3 = $line3;
    }

    public function getPinCode(): string
    {
        return $this->pinCode;
    }

    public function setPinCode(?string $pinCode): void
    {
        $this->pinCode = $pinCode;
    }

    public function getAddressType(): ?string
    {
        return $this->addressType;
    }

    public function setAddressType(string $addressType): static
    {
        $this->addressType = $addressType;

        return $this;
    }

    public function getOrderHeader(): ?OrderHeader
    {
        return $this->orderHeader;
    }

    public function setOrderHeader(?OrderHeader $orderHeader): void
    {
        $this->orderHeader = $orderHeader;
    }
}
