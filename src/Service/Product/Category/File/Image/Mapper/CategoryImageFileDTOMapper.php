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

    public function mapFormDTO(CategoryFileImageDTO $categoryFileImageDTO): CategoryImageFile
    {
        $categoryFile = $this->categoryFileDTOMapper->mapFormDtoToEntity($categoryFileImageDTO->categoryFileDTO);
        $imageType = $this->categoryImageTypeRepository->findOneBy(['type' => $categoryFileImageDTO->imageType]);

        return $this->categoryImageFileRepository->create($categoryFile, $imageType);

    }

}