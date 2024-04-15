<?php

namespace App\Service\Product\Category\File\Provider;

use App\Service\File\Base\AbstractFileDirectoryPathProvider;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;

/**
 *  Directory Structure:
 *
 *  Category: Base Kernel Dir/public/files/Categorys/{id}/{filename.extension}
 */
class CategoryDirectoryImagePathProvider extends CategoryDirectoryPathProvider
{


    private string $ownPathSegment = '/images';

    /**
     * @param $id
     * @param $filename
     * @return string
     * includes filename
     */
    public function getFullPathForImageFiles($id,$filename): string
    {
        // category id
        return $this->getDirectory($id).$filename;
    }

    public function getDirectory(int $id):string
    {
        return  $this->getPhysicalFilePathForFiles(). '/'.$id.$this->ownPathSegment.'/';
    }
}