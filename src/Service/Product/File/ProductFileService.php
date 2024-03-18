<?php

namespace App\Service\Product\File;

use App\Service\File\FileDirectoryService;

class ProductFileService
{
    private FileDirectoryService $fileDirectoryService;

    public function __construct(
        FileDirectoryService $fileDirectoryService,
    FileService $fileService)
    {
        $this->fileDirectoryService = $fileDirectoryService;
    }



}