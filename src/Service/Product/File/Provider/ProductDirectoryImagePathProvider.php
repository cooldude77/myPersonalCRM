<?php

namespace App\Service\Product\File\Provider;

use App\Entity\Product;
use App\Service\File\Base\AbstractFileDirectoryPathProvider;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/Products/{id}/{filename.extension}
 */
class ProductDirectoryImagePathProvider extends ProductDirectoryPathProvider
{


    private string $ownPathSegment = '/images';


    public function getImageDirectoryPath(int $id):string
    {
        // product/id/images/
        return  $this->getPhysicalFilePathForFiles(). "/{$id}{$this->ownPathSegment}/";
    }

    public function getFullPhysicalPathForFileByName(Product $product, string $fileName): string
    {
        // product/id/images/filename
        return $this->getImageDirectoryPath($product->getId()).$fileName;
    }

}