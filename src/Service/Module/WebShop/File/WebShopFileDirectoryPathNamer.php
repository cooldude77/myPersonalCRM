<?php

namespace App\Service\Module\WebShop\File;

use App\Service\File\Base\AbstractFileDirectoryPathNamer;
use App\Service\File\Interfaces\FileDirectoryPathNamerInterface;

/**
 *  Directory Structure:
 *
 *  WebShop: Base Kernel Dir/public/files/webShops/{id}/{filename.extension}
 */
class WebShopFileDirectoryPathNamer extends AbstractFileDirectoryPathNamer implements FileDirectoryPathNamerInterface
{


    public function getFileFullPath(array $params): string
    {
        return $this->getProjectDir() . $this->getFileBaseDirPathSegment() . '/webShops/'.$params['webShopId'].'/images/';
    }
}