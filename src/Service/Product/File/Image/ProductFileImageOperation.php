<?php

namespace App\Service\Product\File\Image;

use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Repository\ProductImageFileRepository;
use App\Repository\ProductImageTypeRepository;
use App\Service\File\FilePhysicalOperation;
use App\Service\Product\File\Provider\ProductDirectoryImagePathProvider;
use Symfony\Component\HttpFoundation\File\File;


class ProductFileImageOperation
{

    private ProductDirectoryImagePathProvider $productDirectoryImagePathProvider;
    private FilePhysicalOperation $filePhysicalOperation;

    public function __construct( FilePhysicalOperation $filePhysicalOperation, ProductDirectoryImagePathProvider $productDirectoryImagePathProvider)
    {


        $this->productDirectoryImagePathProvider = $productDirectoryImagePathProvider;
        $this->filePhysicalOperation = $filePhysicalOperation;
    }


    public function createOrReplace(ProductFileImageDTO $productFileImageDTO): File
    {
        $dir = $this->productDirectoryImagePathProvider->getImageDirectoryPath($productFileImageDTO->getProductId());

        $fileName = $productFileImageDTO->getFileName();

        return $this->filePhysicalOperation->createOrReplaceFile($productFileImageDTO->getUploadedFile(), $fileName, $dir);
    }

}