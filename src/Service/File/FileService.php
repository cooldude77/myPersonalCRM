<?php

namespace App\Service\File;

use App\Entity\File;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Repository\FileRepository;
use App\Repository\FileTypeRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository,FileTypeRepository $fileTypeRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function mapFileEntity(FileFormDTO $fileFormDTO ): File
    {

        $fileHandle = $fileFormDTO->uploadedFile;
        $fileName = $fileFormDTO->name . '.' . $fileHandle->guessExtension();
        $fileFormDTO->name = $fileName;

        $fileEntity = $this->fileRepository->create();
        $fileEntity->setName($fileFormDTO->name);
        $fileEntity->setType($this->fileRepository->findOneBy($fileFormDTO->type));

        return $fileEntity;
    }

    public function move(File $file, UploadedFile $fileHandle, string $filePath):void
    {
        $fileHandle->move($filePath, $file->getName());
    }

}