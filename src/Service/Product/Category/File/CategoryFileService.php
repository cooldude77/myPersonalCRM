<?php

namespace App\Service\Product\Category\File;

use App\Entity\Category;
use App\Entity\CategoryFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileDTO;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryRepository;
use App\Service\File\FileService;
use Symfony\Component\HttpFoundation\File\File;

class CategoryFileService
{
    private CategoryFileDirectoryPathNamer $categoryFileDirectoryPathNamer;
    private FileService $fileService;
    private CategoryFileRepository $categoryFileRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryFileRepository $categoryFileRepository, CategoryRepository $categoryRepository, CategoryFileDirectoryPathNamer $categoryFileDirectoryPathNamer, FileService $fileService)
    {

        $this->categoryFileDirectoryPathNamer = $categoryFileDirectoryPathNamer;
        $this->fileService = $fileService;
        $this->categoryFileRepository = $categoryFileRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function mapFormDTO(CategoryFileDTO $categoryFileDTO): CategoryFile
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findOneBy(['id' => $categoryFileDTO->categoryId]);

        return $this->categoryFileRepository->create($this->fileService->mapDTOToEntity($categoryFileDTO->fileFormDTO), $category);

    }

    public function moveFile(CategoryFileDTO $categoryFileDTO): File
    {

        return $this->fileService->moveFile($this->categoryFileDirectoryPathNamer,
            $categoryFileDTO->fileFormDTO->uploadedFile,
            $categoryFileDTO->fileFormDTO->name,
            ['CategoryId' => $categoryFileDTO->categoryId]);
    }


}