<?php

namespace App\Service\Product\File;

use App\Service\File\Base\AbstractFileDirectoryPathNamer;
use App\Service\File\Interfaces\FileDirectoryPathNamerInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */
class ProductFileDirectoryPathNamer extends AbstractFileDirectoryPathNamer implements FileDirectoryPathNamerInterface
{


    public function getFullPathForImages(array $params): string
    {
        return $this->getBaseFilePathForFiles(). '/products/'.$params['id'].'/images';
    }


}