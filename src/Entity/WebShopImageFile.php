<?php

namespace App\Entity;

use App\Repository\WebShopImageFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * This entity has foreign key connection to WebShopFile and stores the id of webShop file
 * where file is an image
 * This will be used to store additional data regarding image, for example alt text( not yet done)
 * It has a link to webShop image type using which validation for image dimensions can be done
 *
 */
#[ORM\Entity(repositoryClass: WebShopImageFileRepository::class)]
class WebShopImageFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?WebShopFile $webShopFile = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?WebShopImageType $webShopImageType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebShopFile(): ?WebShopFile
    {
        return $this->webShopFile;
    }

    public function setWebShopFile(WebShopFile $webShopFile): static
    {
        $this->webShopFile = $webShopFile;

        return $this;
    }

    public function getWebShopImageType(): ?WebShopImageType
    {
        return $this->webShopImageType;
    }

    public function setWebShopImageType(?WebShopImageType $webShopImageType): static
    {
        $this->webShopImageType = $webShopImageType;

        return $this;
    }
}
