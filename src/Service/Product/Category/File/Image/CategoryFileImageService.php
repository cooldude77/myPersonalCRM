<?php

namespace App\Service\Product\Category\File\Image;

use App\Entity\CategoryImageFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Repository\CategoryImageFileRepository;
use App\Repository\CategoryImageTypeRepository;
use App\Service\Product\Category\File\CategoryFileService;
use Symfony\Component\HttpFoundation\File\File;

class CategoryFileImageService
{


    private CategoryImageFileRepository $categoryImageFileRepository;
    private CategoryImageTypeRepository $categoryImageTypeRepository;
    private CategoryFileService $categoryFileService;

    public function __construct(
        CategoryImageFileRepository $categoryImageFileRepository,
        CategoryImageTypeRepository $categoryImageTypeRepository,
        CategoryFileService         $categoryFileService)
    {


        $this->categoryImageFileRepository = $categoryImageFileRepository;
        $this->categoryImageTypeRepository = $categoryImageTypeRepository;
        $this->categoryFileService = $categoryFileService;
    }

    public function mapFormDTO(CategoryFileImageDTO $categoryFileImageDTO): CategoryImageFile
    {

        return $this->categoryImageFileRepository->create(
            $this->categoryFileService->mapFormDtoToEntity($categoryFileImageDTO->categoryFileDTO),
        $this->categoryImageTypeRepository->findOneBy(['type'=>$categoryFileImageDTO->imageType]));

    }

    public function moveFile(CategoryFileImageDTO $categoryFileImageDTO): File
    {
        return $this->categoryFileService->moveFile($categoryFileImageDTO->categoryFileDTO);
    }


}