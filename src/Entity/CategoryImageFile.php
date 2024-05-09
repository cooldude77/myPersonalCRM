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
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var CategoryFile|null
     */
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryFile $categoryFile = null;

    /**
     * @var CategoryImageType|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryImageType $categoryImageType = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return CategoryFile|null
     */
    public function getCategoryFile(): ?CategoryFile
    {
        return $this->categoryFile;
    }

    /**
     * @param CategoryFile $categoryFile
     * @return $this
     */
    public function setCategoryFile(CategoryFile $categoryFile): static
    {
        $this->categoryFile = $categoryFile;

        return $this;
    }

    /**
     * @return CategoryImageType|null
     */
    public function getCategoryImageType(): ?CategoryImageType
    {
        return $this->categoryImageType;
    }

    /**
     * @param CategoryImageType|null $categoryImageType
     * @return $this
     */
    public function setCategoryImageType(?CategoryImageType $categoryImageType): static
    {
        $this->categoryImageType = $categoryImageType;

        return $this;
    }

    /**
     * @return FileType
     */
    public function getMimeType():FileType
    {
        return $this->categoryFile->getFile()->getType();

    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->categoryFile->getFile()->getName();
    }


    /**
     * @return Category
     * Helpers
     */
    public function getCategory():Category
    {
        return $this->getCategoryFile()->getCategory();
    }
}
