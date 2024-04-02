<?php

namespace App\Entity;

use App\Repository\WebShopFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebShopFileRepository::class)]
class WebShopFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?WebShop $webShop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebShop(): ?WebShop
    {
        return $this->webShop;
    }

    public function setWebShop(?WebShop $webShop): static
    {
        $this->webShop = $webShop;

        return $this;
    }
}
