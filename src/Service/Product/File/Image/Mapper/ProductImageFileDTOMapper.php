<?php

namespace App\Service\Product\File\Image\Mapper;

use App\Entity\ProductImageFile;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Repository\ProductImageFileRepository;
use App\Repository\ProductImageTypeRepository;
use App\Service\Product\File\Mapper\ProductFileDTOMapper;

class ProductImageFileDTOMapper
{

    private ProductFileDTOMapper $productFileDTOMapper;
    private ProductImageTypeRepository $productImageTypeRepository;
    private ProductImageFileRepository $productImageFileRepository;

    public function __construct(ProductFileDTOMapper $productFileDTOMapper, ProductImageTypeRepository $productImageTypeRepository, ProductImageFileRepository $productImageFileRepository)
    {
        $this->productFileDTOMapper = $productFileDTOMapper;
        $this->productImageTypeRepository = $productImageTypeRepository;
        $this->productImageFileRepository = $productImageFileRepository;
    }

    public function mapDtoToEntityForCreate(ProductFileImageDTO $productFileImageDTO): ProductImageFile
    {


        $productFile = $this->productFileDTOMapper->mapFormDtoToEntityForCreate($productFileImageDTO->productFileDTO);
        $imageType = $this->productImageTypeRepository->findOneBy(['type' => $productFileImageDTO->imageType]);
        return $this->productImageFileRepository->create($productFile, $imageType);

    }

    public function mapDtoToEntityForEdit(ProductFileImageDTO $productFileImageDTO, ProductImageFile $productImageFile): ProductImageFile
    {


        $productFile = $this->productFileDTOMapper->mapFormDtoToEntityForEdit($productFileImageDTO->productFileDTO, $productImageFile->getProductFile());

        $productImageFile->setProductFile($productFile);

        return $productImageFile;


    }

    public function mapEntityToDto(ProductImageFile $productImageFile): ProductFileImageDTO
    {
        $dto = new ProductFileImageDTO();

        $dto->productFileDTO = $this->productFileDTOMapper->mapEntityToDto($productImageFile->getProductFile());

        $dto->imageType = $productImageFile->getProductImageType()->getType();

        return $dto;

    }

}