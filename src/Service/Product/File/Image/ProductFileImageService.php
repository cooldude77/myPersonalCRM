<?php

namespace App\Service\Product\File\Image;

use App\Entity\ProductImageFile;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Repository\ProductImageFileRepository;
use App\Repository\ProductImageTypeRepository;
use App\Service\File\FileService;
use App\Service\Product\File\ProductFileService;
use App\Service\Product\File\Provider\ProductDirectoryImagePathProvider;
use Symfony\Component\HttpFoundation\File\File;

class ProductFileImageService
{

    private ProductImageFileRepository $productImageFileRepository;
    private ProductImageTypeRepository $productImageTypeRepository;
    private ProductFileService $productFileService;
    private ProductDirectoryImagePathProvider $productDirectoryImagePathProvider;
    private FileService $fileService;

    public function __construct(ProductImageFileRepository        $productImageFileRepository,
                                ProductImageTypeRepository        $productImageTypeRepository,
                                ProductFileService                $productFileService,
                                FileService                        $fileService,
                                ProductDirectoryImagePathProvider $productDirectoryImagePathProvider)
    {


        $this->productImageFileRepository = $productImageFileRepository;
        $this->productImageTypeRepository = $productImageTypeRepository;
        $this->productFileService = $productFileService;
        $this->productDirectoryImagePathProvider = $productDirectoryImagePathProvider;
        $this->fileService = $fileService;
    }

    public function mapFormDTO(ProductFileImageDTO $productFileImageDTO): ProductImageFile
    {
        $productFile = $this->productFileService->mapFormDtoToEntity($productFileImageDTO->productFileDTO);
        $imageType = $this->productImageTypeRepository->findOneBy(['type' => $productFileImageDTO->imageType]);

        return $this->productImageFileRepository->create($productFile,
            $imageType);

    }

    public function moveFile(ProductFileImageDTO $productFileImageDTO): File
    {
        $dir = $this->productDirectoryImagePathProvider->getDirectory($productFileImageDTO->getProductId());

        $fileName = $productFileImageDTO->getFileName();

        return $this->fileService->moveFile(
            $productFileImageDTO->getUploadedFile(),
            $fileName,
            $dir);
    }

    public function getFullPhysicalPathForFileByName(int    $id,
                                                     string $fileName): string
    {
        return $this->productDirectoryImagePathProvider->getFullPathForImageFiles($id,
            $fileName);
    }




}