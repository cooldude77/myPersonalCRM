<?php

namespace App\Entity;

use App\Repository\WebshopHomeSectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebshopHomeSectionRepository::class)]
class WebshopHomeSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $header = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $footer = null;

    #[ORM\Column]
    private ?int $sectionOrder = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?WebshopHome $webshopHome = null;

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

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(string $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function getFooter(): ?string
    {
        return $this->footer;
    }

    public function setFooter(string $footer): static
    {
        $this->footer = $footer;

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

    public function getWebshopHome(): ?WebshopHome
    {
        return $this->webshopHome;
    }

    public function setWebshopHome(?WebshopHome $webshopHome): static
    {
        $this->webshopHome = $webshopHome;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
