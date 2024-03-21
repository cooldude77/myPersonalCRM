<?php

namespace App\Form\Admin\Product\Category\File\DTO;

use App\Entity\CategoryImageFile;
use App\Entity\CategoryImageType;

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

    public function create()
    {
        return new CategoryImageFileDTO();
    }


}