<?php

namespace App\Entity;

use App\Repository\ProductFileRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * Product File has a connection to file class.
 * It stores all kinds of file related to a product ( images, docs etc)
 */
#[ORM\Entity(repositoryClass: ProductFileRepository::class)]
class ProductFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?File $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): static
    {
        $this->file = $file;

        return $this;
    }
}
