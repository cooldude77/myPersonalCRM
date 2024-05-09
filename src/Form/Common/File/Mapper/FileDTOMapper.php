<?php

namespace App\Form\Common\File\Mapper;

use App\Entity\File;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Repository\FileRepository;
use App\Repository\FileTypeRepository;

class FileDTOMapper
{

    private FileTypeRepository $fileTypeRepository;
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository, FileTypeRepository $fileTypeRepository)
    {
        $this->fileTypeRepository = $fileTypeRepository;
        $this->fileRepository = $fileRepository;
    }

    public function mapToFileEntityForCreate(FileFormDTO $fileFormDTO): File
    {

        $fileHandle = $fileFormDTO->uploadedFile;

        $fileEntity = $this->fileRepository->create();

        $fileName = $fileFormDTO->name . '.' . $fileHandle->guessExtension();
        $fileFormDTO->name = $fileName;

        $fileEntity->setName($fileFormDTO->name);


        $type = $this->fileTypeRepository->findOneBy(['type' => $fileFormDTO->type]);

        $fileEntity->setType($type);

        $fileEntity->setYourFileName($fileFormDTO->yourFileName);

        return $fileEntity;

    }

    public function mapToFileEntityForEdit(FileFormDTO $fileFormDTO, File $fileEntity): File
    {

        $fileEntity->setYourFileName($fileFormDTO->yourFileName);

        return $fileEntity;

    }

    public function mapEntityToFileDto(File $file): FileFormDTO
    {
        $fileDTO = new FileFormDTO();
        $fileDTO->id = $file->getId();
        $fileDTO->yourFileName = $file->getYourFileName();
        $fileDTO->name = $file->getName();
        return $fileDTO;

    }

}