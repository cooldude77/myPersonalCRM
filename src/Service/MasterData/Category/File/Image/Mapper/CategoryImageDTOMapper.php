<?php

namespace App\Service\MasterData\Category\File\Image\Mapper;

use App\Entity\CategoryImage;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Form\MasterData\Category\File\DTO\CategoryImageDTO;
use App\Repository\CategoryImageRepository;
class CategoryImageDTOMapper
{

    private FileDTOMapper $fileDTOMapper;
    private CategoryImageRepository $categoryImageRepository;

    public function __construct(FileDTOMapper $fileDTOMapper, CategoryImageRepository $categoryImageRepository)
    {
        $this->fileDTOMapper = $fileDTOMapper;
        $this->categoryImageRepository = $categoryImageRepository;
    }

    public function mapDtoToEntityForCreate(CategoryImageDTO $fileImageDTO): CategoryImage
    {


        $file = $this->fileDTOMapper->mapToFileEntityForCreate($fileImageDTO->fileFormDTO);

        return $this->categoryImageRepository->create($file);

    }

    public function mapDtoToEntityForEdit(CategoryImageDTO $fileImageDTO, CategoryImage $categoryImage): CategoryImage
    {


        $file = $this->fileDTOMapper->mapToFileEntityForEdit($fileImageDTO->fileFormDTO,
            $categoryImage->getFile());

        $categoryImage->setFile($file);

        return $categoryImage;


    }

    public function mapEntityToDto(CategoryImage $categoryImage): CategoryImageDTO
    {
        $dto = new CategoryImageDTO();

        $dto->fileFormDTO = $this->fileDTOMapper->mapEntityToFileDto($categoryImage->getFile());


        return $dto;

    }

}