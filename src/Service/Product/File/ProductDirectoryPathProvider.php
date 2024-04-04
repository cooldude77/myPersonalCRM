<?php

namespace App\Service\Product\File;

use App\Service\File\Base\AbstractFileDirectoryPathNamer;
use App\Service\File\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */
class ProductDirectoryPathProvider extends AbstractFileDirectoryPathNamer implements DirectoryPathProviderInterface
{


    public function getFullPathForImages(array $params): string
    {
        return $this->getBaseFilePathForFiles(). '/products/'.$params['id'].'/images';
    }


}