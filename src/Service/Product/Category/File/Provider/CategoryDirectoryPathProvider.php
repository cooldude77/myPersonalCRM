<?php

namespace App\Service\Product\Category\File\Provider;

use App\Service\File\Base\AbstractFileDirectoryPathProvider;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Category: Base Kernel Dir/public/files/Categorys/{id}/{filename.extension}
 */
class CategoryDirectoryPathProvider extends AbstractFileDirectoryPathProvider implements DirectoryPathProviderInterface
{

    private string $ownPathSegment = '/category';


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