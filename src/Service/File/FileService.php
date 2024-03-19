<?php

namespace App\Service\File;

use App\Service\File\Interfaces\FileDirectoryPathNamerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private FileGeneralDirectoryPathNamer $fileDirectoryPathNamer;


    /**
     * @param FileGeneralDirectoryPathNamer $fileDirectoryPathNamer
     */
    public function __construct(FileGeneralDirectoryPathNamer $fileDirectoryPathNamer)
    {
        $this->fileDirectoryPathNamer = $fileDirectoryPathNamer;
    }

    public function processFile(UploadedFile $fileHandle, $fileName): File
    {
        $path = $this->fileDirectoryPathNamer->getFileFullPath([]);
        return $fileHandle->move($path, $fileName);
    }
}