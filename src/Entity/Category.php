<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'category', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn]
    private ?self $parent = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'parent', cascade: ['persist', 'remove'])]
    private ?self $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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

    public function getCategory(): ?self
    {
        return $this->category;
    }

    public function setCategory(self $category): static
    {
        // set the owning side of the relation if necessary
        if ($category->getParent() !== $this) {
            $category->setParent($this);
        }

        $this->category = $category;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function __toString()
    {
        return $this->description; //or anything else
    }

}
