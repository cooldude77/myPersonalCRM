<?php

namespace App\Service\Product\Category\File\Image;

use App\Entity\CategoryImageFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Repository\CategoryImageFileRepository;
use App\Repository\CategoryImageTypeRepository;
use App\Service\File\FileService;
use App\Service\Product\Category\File\CategoryFileService;
use App\Service\Product\Category\File\Provider\CategoryDirectoryImagePathProvider;
use Symfony\Component\HttpFoundation\File\File;


class CategoryFileImageService
{


    private CategoryImageFileRepository $categoryImageFileRepository;
    private CategoryImageTypeRepository $categoryImageTypeRepository;
    private CategoryFileService $categoryFileService;
    private CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider;
    private FileService $fileService;

    public function __construct(CategoryImageFileRepository        $categoryImageFileRepository,
                                CategoryImageTypeRepository        $categoryImageTypeRepository,
                                CategoryFileService                $categoryFileService,
                                FileService                       $fileService,
                                CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider)
    {


        $this->categoryImageFileRepository = $categoryImageFileRepository;
        $this->categoryImageTypeRepository = $categoryImageTypeRepository;
        $this->categoryFileService = $categoryFileService;
        $this->categoryDirectoryImagePathProvider = $categoryDirectoryImagePathProvider;
        $this->fileService = $fileService;
    }

    public function mapFormDTO(CategoryFileImageDTO $categoryFileImageDTO): CategoryImageFile
    {
        $categoryFile = $this->categoryFileService->mapFormDtoToEntity($categoryFileImageDTO->categoryFileDTO);
        $imageType = $this->categoryImageTypeRepository->findOneBy(['type' => $categoryFileImageDTO->imageType]);

        return $this->categoryImageFileRepository->create($categoryFile,
            $imageType);

    }

    public function moveFile(CategoryFileImageDTO $categoryFileImageDTO): File
    {
        $dir = $this->categoryDirectoryImagePathProvider->getDirectory($categoryFileImageDTO->getCategoryId());

        $fileName = $categoryFileImageDTO->getFileName();

        return $this->fileService->moveFile(
            $categoryFileImageDTO->getUploadedFile(),
            $fileName,
            $dir);
    }

    public function getFullPhysicalPathForFileByName(int    $id,
                                                     string $fileName): string
    {
        return $this->categoryDirectoryImagePathProvider->getFullPathForImageFiles($id,
            $fileName);
    }


}