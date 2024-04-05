<?php

namespace App\Service\Product\Category\File;

use App\Service\File\Base\AbstractFileDirectoryPathNamer;
use App\Service\File\Interfaces\FileDirectoryPathNamerInterface;

/**
 *  Directory Structure:
 *
 *  Category: Base Kernel Dir/public/files/Categorys/{id}/{filename.extension}
 */
class CategoryFileDirectoryPathNamer extends AbstractFileDirectoryPathNamer implements FileDirectoryPathNamerInterface
{


    public function getFullPathForImages(array $params): string
    {
        // category id
        return $this->getBaseFilePathForFiles(). '/categories/'.$params['id'].'/images';
    }
}