<?php

namespace App\Service\Product\Category\File\Image\Mapper;

use App\Entity\CategoryImageFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Repository\CategoryImageFileRepository;
use App\Repository\CategoryImageTypeRepository;
use App\Service\Product\Category\File\Mapper\CategoryFileDTOMapper;

class CategoryImageFileDTOMapper
{

    private CategoryFileDTOMapper $categoryFileDTOMapper;
    private CategoryImageTypeRepository $categoryImageTypeRepository;
    private CategoryImageFileRepository $categoryImageFileRepository;

    public function __construct(CategoryFileDTOMapper $categoryFileDTOMapper, CategoryImageTypeRepository $categoryImageTypeRepository, CategoryImageFileRepository $categoryImageFileRepository)
    {
        $this->categoryFileDTOMapper = $categoryFileDTOMapper;
        $this->categoryImageTypeRepository = $categoryImageTypeRepository;
        $this->categoryImageFileRepository = $categoryImageFileRepository;
    }

    public function mapDtoToEntityForCreate(CategoryFileImageDTO $categoryFileImageDTO): CategoryImageFile
    {


        $categoryFile = $this->categoryFileDTOMapper->mapFormDtoToEntityForCreate($categoryFileImageDTO->categoryFileDTO);
        $imageType = $this->categoryImageTypeRepository->findOneBy(['type' => $categoryFileImageDTO->imageType]);
        return $this->categoryImageFileRepository->create($categoryFile, $imageType);

    }

    public function mapDtoToEntityForEdit(CategoryFileImageDTO $categoryFileImageDTO, CategoryImageFile $categoryImageFile): CategoryImageFile
    {


        $categoryFile = $this->categoryFileDTOMapper->mapFormDtoToEntityForEdit($categoryFileImageDTO->categoryFileDTO, $categoryImageFile->getCategoryFile());

        $categoryImageFile->setCategoryFile($categoryFile);

        return $categoryImageFile;


    }

    public function mapEntityToDto(CategoryImageFile $categoryImageFile): CategoryFileImageDTO
    {
        $dto = new CategoryFileImageDTO();

        $dto->categoryFileDTO = $this->categoryFileDTOMapper->mapEntityToDto($categoryImageFile->getCategoryFile());

        $dto->imageType = $categoryImageFile->getCategoryImageType()->getType();

        return $dto;

    }

}