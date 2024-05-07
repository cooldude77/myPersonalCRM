<?php

namespace App\Form\MasterData\Product\File\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    /**
     * @return ProductFileImageDTO
     */
    public function create() : ProductFileImageDTO
    {
        return new ProductFileImageDTO();
    }

    public function getProductId():int
    {
        return $this->productFileDTO->productId;
    }

    public function getFileName():string
    {
        return $this->productFileDTO->fileFormDTO->name;
    }

    public function getUploadedFile():UploadedFile
    {
        return $this->productFileDTO->fileFormDTO->uploadedFile;
    }

}