<?php

namespace App\Entity;

use App\Repository\CategoryImageFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * This entity has foreign key connection to CategoryFile and stores the id of Category file
 * where file is an image
 * This will be used to store additional data regarding image, for example alt text( not yet done)
 * It has a link to Category image type using which validation for image dimensions can be done
 *
 */
#[ORM\Entity(repositoryClass: CategoryImageFileRepository::class)]
class CategoryImageFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryFile $categoryFile = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryImageType $categoryImageType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryFile(): ?CategoryFile
    {
        return $this->categoryFile;
    }

    public function setCategoryFile(CategoryFile $categoryFile): static
    {
        $this->categoryFile = $categoryFile;

        return $this;
    }

    public function getCategoryImageType(): ?CategoryImageType
    {
        return $this->categoryImageType;
    }

    public function setCategoryImageType(?CategoryImageType $categoryImageType): static
    {
        $this->categoryImageType = $categoryImageType;

        return $this;
    }

    public function getMimeType():FileType
    {
        return $this->categoryFile->getFile()->getType();

    }

    public function getName():string
    {
        return $this->categoryFile->getFile()->getName();
    }


    public function getCategory():Category
    {
        return $this->getCategoryFile()->getCategory();
    }
}
