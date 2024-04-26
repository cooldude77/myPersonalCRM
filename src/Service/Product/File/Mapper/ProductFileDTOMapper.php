<?php

namespace App\Service\Product\File\Mapper;

use App\Entity\Product;
use App\Entity\ProductFile;
use App\Form\Admin\Product\File\DTO\ProductFileDTO;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Repository\ProductFileRepository;
use App\Repository\ProductRepository;

class ProductFileDTOMapper
{

    private ProductRepository $productRepository;
    private FileDTOMapper $fileDTOMapper;
    private ProductFileRepository $productFileRepository;

    public function __construct(ProductRepository $productRepository, FileDTOMapper $fileDTOMapper, ProductFileRepository $productFileRepository)
    {
        $this->productRepository = $productRepository;
        $this->fileDTOMapper = $fileDTOMapper;
        $this->productFileRepository = $productFileRepository;
    }

    public function mapFormDtoToEntityForCreate(ProductFileDTO $productFileDTO): ProductFile
    {
        /** @var Product $product */
        $product = $this->productRepository->findOneBy(['id' => $productFileDTO->productId]);
        $file = $this->fileDTOMapper->mapToFileEntityForCreate($productFileDTO->fileFormDTO);
        return $this->productFileRepository->create($file, $product);

    }
    public function mapFormDtoToEntityForEdit(ProductFileDTO $productFileDTO,ProductFile $productFile): ProductFile
    {
       $file = $this->fileDTOMapper->mapToFileEntityForEdit($productFileDTO->fileFormDTO,$productFile->getFile());

       $productFile->setFile($file);

       return $productFile;

    }

    public function mapEntityToDto(ProductFile $productFile): ProductFileDTO
    {

        $dto = new ProductFileDTO();
        $dto->productId = $productFile->getProduct()->getId();
        $dto->fileFormDTO = $this->fileDTOMapper->mapEntityToFileDto($productFile->getFile());

        return  $dto;

    }
}