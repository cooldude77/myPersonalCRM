<?php

namespace App\Service\File;

use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    private FileDTOMapper $fileDTOMapper;

    public function __construct(FileDTOMapper $fileDTOMapper)
    {
        $this->fileDTOMapper = $fileDTOMapper;
    }

    public function moveFile(UploadedFile $fileHandle,
                             string       $fileName,
                             string $directoryForFileToBeMoved): File
    {
        return $fileHandle->move($directoryForFileToBeMoved, $fileName);
    }



    public function mapToFileEntity(?\App\Form\Common\File\DTO\FileFormDTO $fileFormDTO): \App\Entity\File
    {
        return $this->fileDTOMapper->mapToFileEntity($fileFormDTO);
    }

}