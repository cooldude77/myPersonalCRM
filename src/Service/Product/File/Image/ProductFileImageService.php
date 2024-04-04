<?php

namespace App\Service\Product\File\Image;

use App\Entity\ProductImageFile;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Repository\ProductImageFileRepository;
use App\Repository\ProductImageTypeRepository;
use App\Service\Product\File\ProductFileService;
use Symfony\Component\HttpFoundation\File\File;

class ProductFileImageService
{


    private ProductImageFileRepository $productImageFileRepository;
    private ProductImageTypeRepository $productImageTypeRepository;
    private ProductFileService $productFileService;

    public function __construct(ProductImageFileRepository $productImageFileRepository,
                                ProductImageTypeRepository $productImageTypeRepository,
                                ProductFileService         $productFileService)
    {


        $this->productImageFileRepository = $productImageFileRepository;
        $this->productImageTypeRepository = $productImageTypeRepository;
        $this->productFileService = $productFileService;
    }

    public function mapFormDTO(ProductFileImageDTO $productFileImageDTO): ProductImageFile
    {

        $productFile = $this->productFileService->mapFormDTO($productFileImageDTO->productFileDTO);
        $productImageType = $this->productImageTypeRepository->findOneBy(['type' => $productFileImageDTO->imageType]);

        return $this->productImageFileRepository->create($productFile,
            $productImageType);

    }

    public function moveFile(ProductFileImageDTO $productFileImageDTO): File
    {
        return $this->productFileService->moveFile($productFileImageDTO->productFileDTO);
    }


}