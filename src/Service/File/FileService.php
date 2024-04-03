<?php

namespace App\Service\File;

use App\Repository\FileRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    private FileGeneralDirectoryPathNamer $fileDirectoryPathNamer;

    public function __construct(FileGeneralDirectoryPathNamer $fileDirectoryPathNamer)
    {

        $this->fileDirectoryPathNamer = $fileDirectoryPathNamer;
    }

    public function moveFile(UploadedFile $fileHandle, string $fileName, array $params): File
    {
        $path = $this->fileDirectoryPathNamer->getFullPathForImages($params);
        return $fileHandle->move($path, $fileName);
    }

    /**
     * @param $fileName
     * @param bool $forTwig
     * @return string
     */
    public function getFilePathSegmentByName($fileName): string
    {
        return $this->fileDirectoryPathNamer->getPublicFilePathSegment() . '/' . $fileName;

    }

}