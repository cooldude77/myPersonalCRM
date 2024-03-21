<?php

namespace App\Entity;

use App\Repository\ProductImageFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * This entity has foreign key connection to ProductFile and stores the id of product file
 * where file is an image
 * This will be used to store additional data regarding image, for example alt text( not yet done)
 * It has a link to product image type using which validation for image dimensions can be done
 *
 */
#[ORM\Entity(repositoryClass: ProductImageFileRepository::class)]
class ProductImageFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductFile $productFile = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductImageType $productImageType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductFile(): ?ProductFile
    {
        return $this->productFile;
    }

    public function setProductFile(ProductFile $productFile): static
    {
        $this->productFile = $productFile;

        return $this;
    }

    public function getProductImageType(): ?ProductImageType
    {
        return $this->productImageType;
    }

    public function setProductImageType(?ProductImageType $productImageType): static
    {
        $this->productImageType = $productImageType;

        return $this;
    }
}
