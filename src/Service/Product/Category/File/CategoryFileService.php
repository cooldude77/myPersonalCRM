<?php

namespace App\Service\Product\Category\File;

use App\Entity\Category;
use App\Entity\CategoryFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileDTO;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryRepository;
use App\Service\File\FilePhysicalOperation;
use App\Service\Product\Category\File\Provider\CategoryDirectoryPathProvider;
use Symfony\Component\HttpFoundation\File\File;

class CategoryFileService
{
    private FilePhysicalOperation $fileService;
    private CategoryFileRepository $categoryFileRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryFileRepository $categoryFileRepository,
                                CategoryRepository     $categoryRepository,
                                FilePhysicalOperation  $fileService)
    {

        $this->fileService = $fileService;
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


}