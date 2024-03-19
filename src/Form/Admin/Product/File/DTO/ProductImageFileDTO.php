<?php

namespace App\Form\Admin\Product\File\DTO;

use App\Entity\ProductFile;
use App\Entity\ProductImageType;

class ProductImageFileDTO
{

    public ?ProductFileDTO $productFileDTO  = null;
    public int $productImageTypeId =0;

    public int $minWidth = 0;
    public int $minHeight= 0;

    public function __construct()
    {
        $this->productFileDTO = new ProductFileDTO();
    }


}