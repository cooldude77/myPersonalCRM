<?php

namespace App\Service\MasterData\Product\File;

use App\Entity\Product;
use App\Entity\ProductFile;
use App\Form\MasterData\Product\File\DTO\ProductFileDTO;
use App\Repository\ProductFileRepository;
use App\Repository\ProductRepository;
use App\Service\Common\File\FilePhysicalOperation;

class ProductFileService
{    private FilePhysicalOperation $fileService;
    private ProductFileRepository $productFileRepository;
    private ProductRepository $productRepository;

    public function __construct(ProductFileRepository $productFileRepository,
                                ProductRepository     $productRepository,
                                FilePhysicalOperation $fileService)
    {

        $this->fileService = $fileService;
        $this->productFileRepository = $productFileRepository;
        $this->productRepository = $productRepository;

    }

    public function mapFormDtoToEntity(ProductFileDTO $productFileDTO): ProductFile
    {
        /** @var Product $product */
        $product = $this->productRepository->findOneBy(['id' => $productFileDTO->productId]);
        $file = $this->fileService->createOrReplaceFile($productFileDTO->fileFormDTO);
        return $this->productFileRepository->create(
            $file,
            $product
        );
    }
}