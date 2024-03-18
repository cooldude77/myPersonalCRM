<?php

namespace App\Service\File;

use App\Entity\File;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Repository\FileRepository;

class FileService
{

    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function mapFileEntity(FileFormDTO $fileFormDTO): File
    {

        $fileHandle = $fileFormDTO['uploadedFile'];
        $fileName = $fileFormDTO->name . '.' . $fileHandle->guessExtension();
        $fileFormDTO->name = $fileName;


        $fileEntity = $this->fileRepository->create();
        $fileEntity->setName($fileFormDTO->name);
        $fileEntity->setType($fileFormDTO->type);

        return $fileEntity;
    }
}