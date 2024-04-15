<?php

namespace App\Form\Admin\Product\Category\File\DTO;

use App\Entity\CategoryImageFile;
use App\Entity\CategoryImageType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CategoryFileImageDTO
{

    public ?CategoryFileDTO $categoryFileDTO  = null;
    public ?string $imageType = null;

    public int $minWidth = 0;
    public int $minHeight= 0;

    public function __construct()
    {
        $this->categoryFileDTO = new CategoryFileDTO();
    }

    /**
     * @return CategoryFileImageDTO
     */
    public function create() : CategoryFileImageDTO
    {
        return new CategoryFileImageDTO();
    }

    public function getCategoryId():int
    {
        return $this->categoryFileDTO->categoryId;
    }

    public function getFileName():string
    {
        return $this->categoryFileDTO->fileFormDTO->name;
    }

    public function getUploadedFile():UploadedFile
    {
        return $this->categoryFileDTO->fileFormDTO->uploadedFile;
    }


}