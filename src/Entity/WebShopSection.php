<?php

namespace App\Entity;

use App\Repository\WebShopHomeSectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebShopHomeSectionRepository::class)]
class WebShopSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $sectionOrder = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?WebShop $webShop = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

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

    
    public function getSectionOrder(): ?int
    {
        return $this->sectionOrder;
    }

    public function setSectionOrder(int $sectionOrder): static
    {
        $this->sectionOrder = $sectionOrder;

        return $this;
    }


    public function __toString(): string
    {
        return $this->name;
    }

    public function getWebShop(): ?WebShop
    {
        return $this->webShop;
    }

    public function setWebShop(?WebShop $webShop): void
    {
        $this->webShop = $webShop;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
