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
    private ?string $name = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn]
    // Note: removed inversedBy: 'category', from above notation
    private ?self $parent = null;


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
