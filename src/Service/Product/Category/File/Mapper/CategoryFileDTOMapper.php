<?php

namespace App\Service\Product\Category\File\Mapper;

use App\Entity\Category;
use App\Entity\CategoryFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileDTO;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryRepository;

class CategoryFileDTOMapper
{

    private CategoryRepository $categoryRepository;
    private FileDTOMapper $fileDTOMapper;
    private CategoryFileRepository $categoryFileRepository;

    public function __construct(\App\Repository\CategoryRepository $categoryRepository, \App\Form\Common\File\Mapper\FileDTOMapper $fileDTOMapper, \App\Repository\CategoryFileRepository $categoryFileRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->fileDTOMapper = $fileDTOMapper;
        $this->categoryFileRepository = $categoryFileRepository;
    }

    public function mapFormDtoToEntity(CategoryFileDTO $categoryFileDTO): CategoryFile
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findOneBy(['id' => $categoryFileDTO->categoryId]);
        $file = $this->fileDTOMapper->mapToFileEntity($categoryFileDTO->fileFormDTO);
        return $this->categoryFileRepository->create($file,
            $category);

    }
}