<?php

namespace App\Form\Admin\Product\Category\Mapper;

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

    public function map(CategoryDTO $categoryDTO,
                        ?Category    $parent =null): Category
    {
        $category = $this->categoryRepository->create();

        $category->setName($categoryDTO->name);
        $category->setDescription($categoryDTO->description);
        $category->setParent($parent);
        return $category;
    }
}