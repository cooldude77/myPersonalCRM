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
     * Mostly for use by twig
     * forTwig is to be true
     * Twig asset function only requires structure below /public
     * {#   <img src="{{ asset('uploads/general/127531954660ce1c79dec26.74006442.jpg') }}"/>#}
     * so public part has to be removed
     */
    public function getFilePathSegmentByName($fileName, $forTwig = false): string
    {
        $path = $this->fileDirectoryPathNamer->getPublicFilePathSegment() . '/' . $fileName;

        return $forTwig ? $this->fileDirectoryPathNamer->removePublicFolderAndSlash($path) : $path;
    }


}