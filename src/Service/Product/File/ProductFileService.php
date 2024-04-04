<?php

namespace App\Service\Product\File;

use App\Entity\Product;
use App\Entity\ProductFile;
use App\Form\Admin\Product\File\DTO\ProductFileDTO;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Repository\ProductFileRepository;
use App\Repository\ProductRepository;
use App\Service\File\FileService;
use App\Service\Product\File\Provider\ProductDirectoryPathProvider;
use Symfony\Component\HttpFoundation\File\File;

class ProductFileService
{
    private FileService $fileService;
    private ProductFileRepository $productFileRepository;
    private ProductRepository $productRepository;
    private FileDTOMapper $fileDTOMapper;

    public function __construct(ProductFileRepository        $productFileRepository,
                                ProductRepository            $productRepository,
                                ProductDirectoryPathProvider $productFileDirectoryPathNamer,
                                FileDTOMapper                $fileDTOMapper,
                                FileService                  $fileService)
    {

        $this->fileService = $fileService;
        $this->fileService->setDirectoryPathProviderInterface($productFileDirectoryPathNamer);
        $this->productFileRepository = $productFileRepository;
        $this->productRepository = $productRepository;
        $this->fileDTOMapper = $fileDTOMapper;
    }

    public function mapFormDTO(ProductFileDTO $productFileDTO): ProductFile
    {
        /** @var Product $product */
        $product = $this->productRepository->findOneBy(['id' => $productFileDTO->productId]);

        $file = $this->fileDTOMapper->mapToFileEntity($productFileDTO->fileFormDTO);

        return $this->productFileRepository->create($file, $product);

    }

    public function moveFile(ProductFileDTO $productFileDTO): File
    {

        return $this->fileService->moveFile($productFileDTO->fileFormDTO->uploadedFile,
            $productFileDTO->fileFormDTO->name,
            ['id' => $productFileDTO->productId]);
    }


}