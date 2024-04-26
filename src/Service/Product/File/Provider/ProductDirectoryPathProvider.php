<?php

namespace App\Service\Product\File\Provider;

use App\Service\File\Base\AbstractFileDirectoryPathProvider;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/Products/{id}/{filename.extension}
 */
class ProductDirectoryPathProvider extends AbstractFileDirectoryPathProvider implements DirectoryPathProviderInterface
{

    private string $ownPathSegment = '/product';


    public function getBaseFolderPath(): string
    {
     return    $this->getPhysicalFilePathForFiles(). $this->ownPathSegment;
    }

    /**
     * @return string
     * Provides complete directory path ( but not the file name )
     */
    protected function getPhysicalFilePathForFiles(): string
    {

        return parent::getPhysicalFilePathForFiles().$this->ownPathSegment;
    }

}