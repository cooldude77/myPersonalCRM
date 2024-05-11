<?php

namespace App\Service\MasterData\Product\Image;

use App\Entity\ProductImage;
use App\Service\Common\File\FilePhysicalOperation;
use App\Service\MasterData\Product\Image\Provider\ProductDirectoryImagePathProvider;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertNotNull;


class ProductImageOperation
{

    private ProductDirectoryImagePathProvider $productDirectoryImagePathProvider;
    private FilePhysicalOperation $filePhysicalOperation;

    public function __construct( FilePhysicalOperation $filePhysicalOperation, ProductDirectoryImagePathProvider $productDirectoryImagePathProvider)
    {


        $this->productDirectoryImagePathProvider = $productDirectoryImagePathProvider;
        $this->filePhysicalOperation = $filePhysicalOperation;
    }


    public function createOrReplace(ProductImage $productImage,UploadedFile $uploadedFile): File
    {

        assertNotEquals($productImage->getProduct()->getId(),0);

        $dir = $this->productDirectoryImagePathProvider->getImageDirectoryPath($productImage->getProduct()->getId());

        assertNotNull($dir);

        $fileName = $productImage->getFile()->getName();

        assertNotNull($fileName);

        return $this->filePhysicalOperation->createOrReplaceFile($uploadedFile, $fileName, $dir);
    }

}