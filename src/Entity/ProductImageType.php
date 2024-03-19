<?php

namespace App\Entity;

use App\Repository\ProductImageTypeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductImageTypeRepository::class)]
class ProductImageType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $minWidth = null;

    #[ORM\Column]
    private ?int $minHeight = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longDescription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
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

    public function getMinWidth(): ?int
    {
        return $this->minWidth;
    }

    public function setMinWidth(int $minWidth): static
    {
        $this->minWidth = $minWidth;

        return $this;
    }

    public function getMinHeight(): ?int
    {
        return $this->minHeight;
    }

    public function setMinHeight(int $minHeight): static
    {
        $this->minHeight = $minHeight;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(string $longDescription): static
    {
        $this->longDescription = $longDescription;

        return $this;
    }
}
