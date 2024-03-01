<?php

namespace App\Entity;

use App\Repository\ProductTypeAttributeValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductTypeAttributeValueRepository::class)]
class ProductTypeAttributeValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'productTypeAttributeValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductTypeAttribute $attribute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getAttribute(): ?ProductTypeAttribute
    {
        return $this->attribute;
    }

    public function setAttribute(?ProductTypeAttribute $attribute): static
    {
        $this->attribute = $attribute;

        return $this;
    }
}
