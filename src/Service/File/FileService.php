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
    private FileDTOMapper $fileDTOMapper;


    /**
     * @param FileGeneralDirectoryPathNamer $fileDirectoryPathNamer
     */
    public function __construct(FileDTOMapper $fileDTOMapper)
    {
        $this->fileDTOMapper = $fileDTOMapper;
    }

    public function moveFile(FileDirectoryPathNamerInterface $fileDirectoryPathNamer, UploadedFile $fileHandle, string $fileName, array $params): File
    {
        $path = $fileDirectoryPathNamer->getFileFullPath($params);
        return $fileHandle->move($path, $fileName);
    }

    public function mapDTOToEntity(FileFormDTO $fileFormDTO): \App\Entity\File
    {
        return $this->fileDTOMapper->mapFileEntity($fileFormDTO);

    }
}