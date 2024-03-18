<?php

namespace App\Service\File;

use App\Entity\File;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Repository\FileRepository;
use App\Repository\FileTypeRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    private FileTypeRepository $fileTypeRepository;
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository,FileTypeRepository $fileTypeRepository)
    {
        $this->fileTypeRepository = $fileTypeRepository;
        $this->fileRepository = $fileRepository;
    }

    public function mapFileEntity(FileFormDTO $fileFormDTO): File
    {

        $fileHandle = $fileFormDTO->uploadedFile;
        $fileName = $fileFormDTO->name . '.' . $fileHandle->guessExtension();
        $fileFormDTO->name = $fileName;

        $fileEntity = $this->fileRepository->create();
        $fileEntity->setName($fileFormDTO->name);
        $type = $this->fileTypeRepository->findOneBy(['type' => $fileFormDTO->type]);
        $fileEntity->setType($type);

        return $fileEntity;
    }

    public function move(UploadedFile $fileHandle, $fileName, string $filePath)
    {
        return $fileHandle->move($filePath, $fileName);
    }

}