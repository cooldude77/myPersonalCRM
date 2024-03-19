<?php

namespace App\Service\Product\File;

use App\Service\File\FileGeneralDirectoryPathNamer;

class ProductFileService
{
    private FileGeneralDirectoryPathNamer $fileDirectoryService;

    public function __construct(
        FileGeneralDirectoryPathNamer $fileDirectoryService,
        FileService                   $fileService)
    {
        $this->fileDirectoryService = $fileDirectoryService;
    }



}