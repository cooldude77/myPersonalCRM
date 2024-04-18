<?php

namespace App\Service\Module\WebShop\File;


use App\Service\File\Base\AbstractFileDirectoryPathProvider;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  WebShop: Base Kernel Dir/public/files/webShops/{id}/{filename.extension}
 */
class WebShopFileDirectoryPathNamer extends AbstractFileDirectoryPathProvider implements DirectoryPathProviderInterface
{


    public function getFileFullPath(array $params): string
    {
        return "";            //$this->getProjectDir() . $this->getFileBaseDirPathSegment() .
        // '/webShops/'
        //.$params['webShopId'].'/images/';
    }

    public function getBaseFolderPath(): string
    {
        // TODO: Implement getBaseFolderPath() method.
        return "";
    }
}