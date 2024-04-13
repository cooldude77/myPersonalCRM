<?php

namespace App\Service\Product\Category\File\Provider;

use App\Service\File\Base\AbstractFileDirectoryPathNamer;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Category: Base Kernel Dir/public/files/Categorys/{id}/{filename.extension}
 */
class CategoryDirectoryPathProvider extends AbstractFileDirectoryPathNamer implements DirectoryPathProviderInterface
{


    public function getFullPathForFiles(array $params): string
    {
        // category id
        return $this->getBaseFilePathForFiles(). '/categories/'.$params['id'].'/images';
    }
}