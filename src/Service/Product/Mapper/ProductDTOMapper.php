<?php

namespace App\Service\Product\Mapper;

use App\Entity\Product;
use App\Form\Admin\Product\DTO\ProductDTO;
use App\Repository\ProductRepository;

class ProductDTOMapper
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    public function mapToEntity(ProductDTO $productDTO): Product
    {
        $product = $this->productRepository->create();

        $product->setName($productDTO->name);
        $product->setDescription($productDTO->description);


        $product->setParent();
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