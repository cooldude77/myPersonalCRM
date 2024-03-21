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


    public function getFileFullPath(array $params): string
    {
        return $this->getProjectDir() . $this->getFileBaseDirPathSegment() . '/categories/'.$params['CategoryId'].'/images/';
    }
}