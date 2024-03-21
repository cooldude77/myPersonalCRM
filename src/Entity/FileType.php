<?php

namespace App\Entity;

use App\Repository\FileTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is subclass of FileType and determines the valid file types for each
 * base file type
 * like jpeg, png for images
 * pdf, doc, excel for document
 */
#[ORM\Entity(repositoryClass: FileTypeRepository::class)]
class FileType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FileBaseType $baseType = null;

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

    public function getBaseType(): ?FileBaseType
    {
        return $this->baseType;
    }

    public function setBaseType(?FileBaseType $baseType): static
    {
        $this->baseType = $baseType;

        return $this;
    }
    public function __toString(): string
    {
       return $this->type;
    }
}
