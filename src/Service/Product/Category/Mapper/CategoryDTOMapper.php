<?php

namespace App\Service\Product\Category\Mapper;

use App\Entity\Category;
use App\Form\Admin\Product\Category\DTO\CategoryDTO;
use App\Repository\CategoryRepository;

class CategoryDTOMapper
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {

        $this->categoryRepository = $categoryRepository;
    }

    public function mapToEntityForCreate(CategoryDTO $categoryDTO): Category
    {
        $category = $this->categoryRepository->create();

        $category->setName($categoryDTO->name);
        $category->setDescription($categoryDTO->description);

        $category->setParent($this->categoryRepository->findOneBy(['name' => $categoryDTO->parent]));
        return $category;
    }

    public function mapToEntityForEdit(CategoryDTO $categoryDTO, ?Category $category = null): Category
    {

        $category->setName($categoryDTO->name);
        $category->setDescription($categoryDTO->description);
        if ($category->getParent()->getName() != $categoryDTO->parent)
            $category->setParent($this->categoryRepository->findOneBy(['name' => $categoryDTO->parent]));


        return $category;
    }

    public function mapFromEntity(?Category $category): CategoryDTO
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->id = $category->getId();
        $categoryDTO->name = $category->getName();
        $categoryDTO->description = $category->getDescription();
        return $categoryDTO;

    }
}