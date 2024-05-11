<?php

namespace App\Form\Common\File\Mapper;

use App\Entity\File;
use App\Form\Common\File\DTO\FileDTO;
use App\Repository\FileRepository;

class FileDTOMapper
{

    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function mapToFileEntityForCreate(FileDTO $fileFormDTO): File
    {

        $fileHandle = $fileFormDTO->uploadedFile;

        $fileEntity = $this->fileRepository->create();

        $fileName = $fileFormDTO->name . '.' . $fileHandle->guessExtension();
        $fileFormDTO->name = $fileName;

        $fileEntity->setName($fileFormDTO->name);


        $fileEntity->setYourFileName($fileFormDTO->yourFileName);

        return $fileEntity;

    }

    public function mapToFileEntityForEdit(FileDTO $fileFormDTO, File $fileEntity): File
    {

        $fileEntity->setYourFileName($fileFormDTO->yourFileName);

        return $fileEntity;

    }

    public function mapEntityToFileDto(File $file): FileDTO
    {
        $fileDTO = new FileDTO();
        $fileDTO->id = $file->getId();
        $fileDTO->yourFileName = $file->getYourFileName();
        $fileDTO->name = $file->getName();
        return $fileDTO;

    }

}