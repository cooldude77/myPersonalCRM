<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *  File contains all files anywhere in the system
 * The table has name of file and File Type (document,image,video etc)
 */

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FileType $type = null;

    #[ORM\Column(length: 255)]
    private ?string $yourFileName = null;

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

    public function getType(): ?FileType
    {
        return $this->type;
    }

    public function setType(?FileType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getYourFileName(): ?string
    {
        return $this->yourFileName;
    }

    public function setYourFileName(string $yourFileName): static
    {
        $this->yourFileName = $yourFileName;

        return $this;
    }
}
