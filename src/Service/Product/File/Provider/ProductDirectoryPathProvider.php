<?php

namespace App\Service\Product\File\Provider;

use App\Service\File\Base\AbstractFileDirectoryPathProvider;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */
class ProductDirectoryPathProvider extends AbstractFileDirectoryPathProvider implements DirectoryPathProviderInterface
{


    public function getFullPathForImageFiles(array $params): string
    {
        return $this->getPhysicalFilePathForFiles(). '/products/'.$params['id'].'/images';
    }


    public function getBaseFolderPath(): string
    {
        // TODO: Implement getBaseFolderPath() method.
    }
}