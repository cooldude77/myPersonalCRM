<?php

namespace App\Service\MasterData\Product\Mapper;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Form\FormInterface;

class ProductDTOMapper
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    public function mapToEntityForCreate(FormInterface $form): Product
    {
        /** @var Category $category */
        $category = $form->get('category')->getData();
        $productDTO = $form->getData();

        $product = $this->productRepository->create($category);

        $product->setName($productDTO->name);
        $product->setDescription($productDTO->description);


        return $product;
    }


    public function mapToEntityForEdit(FormInterface $form, Product $product)
    {
        /** @var Category $category */
        $category = $form->get('category')->getData();
        $productDTO = $form->getData();

        $product = $this->productRepository->create($category);

        $product->setName($productDTO->name);
        $product->setDescription($productDTO->description);


        return $product;

    }
}