<?php

namespace App\Service\Product\Category\File;

use App\Entity\Category;
use App\Entity\CategoryFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileDTO;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryRepository;
use App\Service\File\FileService;
use App\Service\Product\Category\File\Provider\CategoryDirectoryPathProvider;
use Symfony\Component\HttpFoundation\File\File;

class CategoryFileService
{
    private FileService $fileService;
    private CategoryFileRepository $categoryFileRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryFileRepository        $categoryFileRepository,
                                CategoryRepository            $categoryRepository,
                                CategoryDirectoryPathProvider $categoryFileDirectoryPathNamer,
                                FileDTOMapper                 $fileDTOMapper,
                                FileService                   $fileService)
    {

        $this->fileService = $fileService;
        $this->fileService->setDirectoryPathProviderInterface($categoryFileDirectoryPathNamer);
        $this->categoryFileRepository = $categoryFileRepository;
        $this->categoryRepository = $categoryRepository;

    }

    public function mapFormDtoToEntity(CategoryFileDTO $categoryFileDTO): CategoryFile
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findOneBy(['id' => $categoryFileDTO->categoryId]);
        $file = $this->fileService->mapToFileEntity($categoryFileDTO->fileFormDTO);
        return $this->categoryFileRepository->create($file,
            $category);

    }

    public function moveFile(CategoryFileDTO $categoryFileDTO): File
    {

        return $this->fileService->moveFile($categoryFileDTO->fileFormDTO->uploadedFile,
            $categoryFileDTO->fileFormDTO->name,
            ['id' => $categoryFileDTO->categoryId]);
    }

    public function getFullPhysicalPathForFileByName(string $fileName): string
    {
        return   $this->fileService->getFullPhysicalPathForFileByName($fileName);
    }


}