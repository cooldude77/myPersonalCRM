<?php

namespace App\Service\MasterData\Product\File\Image;

use App\Entity\ProductImageFile;
use App\Form\MasterData\Product\File\DTO\ProductFileImageDTO;
use App\Repository\ProductImageFileRepository;
use App\Repository\ProductImageTypeRepository;
use App\Service\Common\File\FilePhysicalOperation;
use App\Service\MasterData\Product\File\ProductFileService;
use App\Service\MasterData\Product\File\Provider\ProductDirectoryImagePathProvider;
use Symfony\Component\HttpFoundation\File\File;

class ProductFileImageService
{

    private ProductImageFileRepository $productImageFileRepository;
    private ProductImageTypeRepository $productImageTypeRepository;
    private ProductFileService $productFileService;
    private ProductDirectoryImagePathProvider $productDirectoryImagePathProvider;
    private FilePhysicalOperation $fileService;

    public function __construct(ProductImageFileRepository        $productImageFileRepository,
                                ProductImageTypeRepository        $productImageTypeRepository,
                                ProductFileService                $productFileService,
                                FilePhysicalOperation             $fileService,
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

        return $this->fileService->createOrReplaceFile(
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