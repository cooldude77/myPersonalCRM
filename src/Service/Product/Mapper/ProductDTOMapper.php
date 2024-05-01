<?php

namespace App\Service\Product\Mapper;

use App\Entity\Product;
use App\Form\Admin\Product\DTO\ProductDTO;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class ProductDTOMapper
{
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(ProductRepository $productRepository,
        CategoryRepository $categoryRepository)
    {

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function mapToEntityForCreate(ProductDTO $productDTO): Product
    {

        $category = $this->categoryRepository->findOneBy(['id'=>$productDTO->category]);
        $product = $this->productRepository->create($category);

        $product->setName($productDTO->name);
        $product->setDescription($productDTO->description);


        return $product;
    }

    public function mapFromEntity(?Product $product): ProductDTO
    {
        $productDTO = new ProductDTO();
        $productDTO->id = $product->getId();
        $productDTO->name = $product->getName();
        $productDTO->description = $product->getDescription();
        return $productDTO;

    }
}