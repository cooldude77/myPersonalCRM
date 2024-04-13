<?php

namespace App\Service\File;

use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    private DirectoryPathProviderInterface $directoryPathProviderInterface;
    private FileDTOMapper $fileDTOMapper;

    public function __construct(FileDTOMapper $fileDTOMapper)
    {
        $this->fileDTOMapper = $fileDTOMapper;
    }

    public function moveFile(UploadedFile $fileHandle,
                             string       $fileName,
                             array        $params): File
    {
        $path = $this->directoryPathProviderInterface->getFullPathForFiles([]);
        return $fileHandle->move($path,
            $fileName);
    }

    /**
     * @param $fileName
     * @return string
     */
    public function getFilePathSegmentByName($fileName): string
    {
        return $this->directoryPathProviderInterface->getBaseFilePathSegment() . '/' . $fileName;

    }

    public function setDirectoryPathProviderInterface(DirectoryPathProviderInterface $directoryPathProviderInterface): void
    {
        $this->directoryPathProviderInterface = $directoryPathProviderInterface;
    }

    public function mapToFileEntity(?\App\Form\Common\File\DTO\FileFormDTO $fileFormDTO): \App\Entity\File
    {
        return $this->fileDTOMapper->mapToFileEntity($fileFormDTO);
    }


 public function getFullPhysicalPathForFileByName(string $fileName) :string
 {
     return   $this->directoryPathProviderInterface->getFullPathForFiles([]).'/'.$fileName;

 }
}