<?php

namespace App\Service\File;

use App\Service\File\Base\AbstractFileDirectoryPathNamer;
use App\Service\File\Interfaces\FileDirectoryPathNamerInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */


class FileGeneralDirectoryPathNamer extends AbstractFileDirectoryPathNamer implements FileDirectoryPathNamerInterface
{

    private $additionalPath = '/general';


    /**
     * @param array $params
     * @return string
     * Doesn't include file name
     */
    public function getFullPathForImages(array $params): string
    {
        return $this->getBaseFilePathForFiles() . $this->additionalPath;
    }

    public function getPublicFilePathSegment(): string
    {
        return parent::getPublicFilePathSegment(). $this->additionalPath; 
    }


}