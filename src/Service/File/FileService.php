<?php

namespace App\Service\File;

use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Service\File\Interfaces\FileDirectoryPathNamerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    private FileGeneralDirectoryPathNamer $fileDirectoryPathNamer;

    public function __construct(FileGeneralDirectoryPathNamer $fileDirectoryPathNamer)
    {

        $this->fileDirectoryPathNamer = $fileDirectoryPathNamer;
    }
    public function moveFile( UploadedFile $fileHandle, string $fileName, array $params): File
    {
        $path = $this->fileDirectoryPathNamer->getFileFullPathImage($params);
        return $fileHandle->move($path, $fileName);
    }

    public function getFilePathByName($name):string{

        return "";
    }
    public function getFilePathByYourFileName($yourFileName):string{
        return "";
    }
}