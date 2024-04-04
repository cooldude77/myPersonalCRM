<?php

namespace App\Service\Product\File\Image;

use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Repository\ProductImageFileRepository;
use App\Repository\ProductImageTypeRepository;
use App\Service\Product\File\ProductFileService;

class ProductFileImageService
{


    private ProductImageFileRepository $productImageFileRepository;
    private ProductImageTypeRepository $productImageTypeRepository;
    private ProductFileService $productFileService;

    public function __construct(
        ProductImageFileRepository $productImageFileRepository,
        ProductImageTypeRepository $productImageTypeRepository,
        ProductFileService         $productFileService)
    {


        $this->productImageFileRepository = $productImageFileRepository;
        $this->productImageTypeRepository = $productImageTypeRepository;
        $this->productFileService = $productFileService;
    }

    public function mapFormDTO(ProductFileImageDTO $productFileImageDTO): \App\Entity\ProductImageFile
    {

        return $this->productImageFileRepository->create(
            $this->productFileService->mapFormDTO($productFileImageDTO->productFileDTO),
        $this->productImageTypeRepository->findOneBy(['type'=>$productFileImageDTO->imageType]));

    }

    public function moveFile(ProductFileImageDTO $productFileImageDTO): \Symfony\Component\HttpFoundation\File\File
    {
        return $this->productFileService->moveFile($productFileImageDTO->productFileDTO);
    }


}