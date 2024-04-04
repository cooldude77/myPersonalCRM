<?php

namespace App\Service\Product\File;

use App\Entity\Product;
use App\Entity\ProductFile;
use App\Form\Admin\Product\File\DTO\ProductFileDTO;
use App\Repository\ProductFileRepository;
use App\Repository\ProductRepository;
use App\Service\File\FileService;

class ProductFileService
{
    private ProductDirectoryPathProvider $productFileDirectoryPathNamer;
    private FileService $fileService;
    private ProductFileRepository $productFileRepository;
    private ProductRepository $productRepository;

    public function __construct(ProductFileRepository $productFileRepository, ProductRepository $productRepository, ProductDirectoryPathProvider $productFileDirectoryPathNamer, FileService $fileService)
    {

        $this->productFileDirectoryPathNamer = $productFileDirectoryPathNamer;
        $this->fileService = $fileService;
        $this->productFileRepository = $productFileRepository;
        $this->productRepository = $productRepository;
    }

    public function mapFormDTO(ProductFileDTO $productFileDTO): ProductFile
    {
        /** @var Product $product */
        $product = $this->productRepository->findOneBy(['id' => $productFileDTO->productId]);

        return $this->productFileRepository->create($this->fileService->mapDTOToEntity($productFileDTO->fileFormDTO), $product);

    }

    public function moveFile(ProductFileDTO $productFileDTO): \Symfony\Component\HttpFoundation\File\File
    {

        return $this->fileService->moveFile($this->productFileDirectoryPathNamer,
            $productFileDTO->fileFormDTO->uploadedFile,
            $productFileDTO->fileFormDTO->name,
            ['id' => $productFileDTO->productId]);
    }


}