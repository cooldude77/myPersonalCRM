<?php

namespace App\Service\MasterData\Product\File\Provider;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/Product/{id}/{filename.extension}
 */
class ProductDirectoryImagePathProvider extends ProductDirectoryPathProvider
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
        // product id
        return $this->getDirectory($id).$filename;
    }

    public function getDirectory(int $id):string
    {
        return  $this->getPhysicalFilePathForFiles(). '/'.$id.$this->ownPathSegment.'/';
    }
}