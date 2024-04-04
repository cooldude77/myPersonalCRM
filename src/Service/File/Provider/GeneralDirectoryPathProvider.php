<?php

namespace App\Service\File\Provider;

use App\Service\File\Base\AbstractFileDirectoryPathNamer;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */


class GeneralDirectoryPathProvider extends AbstractFileDirectoryPathNamer implements DirectoryPathProviderInterface
{

    private string $ownPathSegment = '/general';


    /**
     * @param array $params
     * @return string
     * Doesn't include file name
     * will return '/public/uploads/general'
     */
    public function getFullPathForImages(array $params): string
    {
        return $this->getBaseFilePathForFiles() . $this->ownPathSegment;
    }

}