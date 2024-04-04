<?php

namespace App\Service\File;

use App\Repository\FileRepository;
use App\Service\File\Interfaces\DirectoryPathProviderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    private DirectoryPathProviderInterface $directoryPathProviderInterface;

    public function __construct(DirectoryPathProviderInterface $directoryPathProvider)
    {

        $this->directoryPathProviderInterface = $directoryPathProvider;
    }

    public function moveFile(UploadedFile $fileHandle, string $fileName, array $params): File
    {
        $path = $this->directoryPathProviderInterface->getFullPathForImages($params);
        return $fileHandle->move($path, $fileName);
    }

    /**
     * @param $fileName
     * @param bool $forTwig
     * @return string
     */
    public function getFilePathSegmentByName($fileName): string
    {
        return $this->directoryPathProviderInterface->getPublicFilePathSegment() . '/' . $fileName;

    }

}