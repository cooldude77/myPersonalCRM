<?php

namespace App\Service\Product\File;

use App\Entity\Product;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Repository\ProductFileRepository;
use App\Repository\ProductImageFileRepository;
use App\Repository\ProductRepository;
use App\Service\File\FileGeneralDirectoryPathNamer;
use App\Service\File\FileService;

class ProductFileService
{
    private ProductFileDirectoryPathNamer $productFileDirectoryPathNamer;
    private FileService $fileService;
    private ProductFileRepository $productFileRepository;
    private ProductImageFileRepository $productImageFileRepository;
    private ProductRepository $productRepository;

    public function __construct(
        ProductFileRepository         $productFileRepository,
        ProductImageFileRepository    $productImageFileRepository,
        ProductRepository             $productRepository,
        ProductFileDirectoryPathNamer $productFileDirectoryPathNamer,
        FileService                   $fileService)
    {

        $this->productFileDirectoryPathNamer = $productFileDirectoryPathNamer;
        $this->fileService = $fileService;
        $this->productFileRepository = $productFileRepository;
        $this->productImageFileRepository = $productImageFileRepository;
        $this->productRepository = $productRepository;
    }

    public function mapFormDTO(ProductFileImageDTO $productFileImageDTO): \App\Entity\ProductImageFile
    {
        /** @var Product $product */
        $product= $this->productRepository->findOneBy(['id'=>$productFileImageDTO->productFileDTO->productId]);

        $productFileEntity = $this->productFileRepository->create($this->fileService->mapDTOToEntity(
            $productFileImageDTO->productFileDTO->fileFormDTO),
            $product);

        return $this->productImageFileRepository->create($productFileEntity);

    }

    public function moveFile(ProductFileImageDTO $productFileImageDTO,int $productId)
    {

        $this->fileService->moveFile(
            $this->productFileDirectoryPathNamer,
            $productFileImageDTO->productFileDTO->fileFormDTO->uploadedFile,
            $productFileImageDTO->productFileDTO->fileFormDTO->name,
            ['productId'=>$productId]);
    }

}