<?php

namespace App\Service\MasterData\Product\Image\Mapper;

use App\Entity\ProductImage;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Form\MasterData\Product\Image\DTO\ProductImageDTO;
use App\Repository\ProductImageRepository;
use App\Repository\ProductRepository;

class ProductImageDTOMapper
{

    public function __construct(private readonly FileDTOMapper $fileDTOMapper,
        private readonly ProductRepository $productRepository,
        private readonly ProductImageRepository $productImageRepository
    ) {
    }

    public function mapDtoToEntityForCreate(ProductImageDTO $productImageDTO): ProductImage
    {

        $product = $this->productRepository->find($productImageDTO->productId);

        $file = $this->fileDTOMapper->mapToFileEntityForCreate($productImageDTO->fileDTO);

        return $this->productImageRepository->create($product, $file);

    }

    public function mapDtoToEntityForEdit(ProductImageDTO $fileImageDTO,
        ProductImage $productImage
    ): ProductImage {


        $file = $this->fileDTOMapper->mapToFileEntityForEdit(
            $fileImageDTO->fileDTO,
            $productImage->getFile()
        );

        $productImage->setFile($file);

        return $productImage;


    }

    public function mapEntityToDto(ProductImage $productImage): ProductImageDTO
    {
        $dto = new ProductImageDTO();

        $dto->fileDTO = $this->fileDTOMapper->mapEntityToFileDto($productImage->getFile());


        return $dto;

    }

}