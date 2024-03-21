<?php

namespace App\Form\Admin\Product\File\DTO;

use App\Entity\ProductFile;
use App\Entity\ProductImageType;

class ProductFileImageDTO
{

    public ?ProductFileDTO $productFileDTO  = null;
    public ?string $imageType = null;

    public int $minWidth = 0;
    public int $minHeight= 0;

    public function __construct()
    {
        $this->productFileDTO = new ProductFileDTO();
    }

    public function create()
    {
        return new $P();
    }


}