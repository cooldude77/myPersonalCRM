<?php

namespace App\Service\Product\Category\File\Image;

use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Repository\CategoryImageFileRepository;
use App\Repository\CategoryImageTypeRepository;
use App\Service\File\FilePhysicalOperation;
use App\Service\File\FileService;
use App\Service\Product\Category\File\CategoryFileService;
use App\Service\Product\Category\File\Provider\CategoryDirectoryImagePathProvider;
use Symfony\Component\HttpFoundation\File\File;


class CategoryFileImageOperation
{

    private CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider;
    private FilePhysicalOperation $filePhysicalOperation;

    public function __construct( FilePhysicalOperation $filePhysicalOperation, CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider)
    {


        $this->categoryDirectoryImagePathProvider = $categoryDirectoryImagePathProvider;
        $this->filePhysicalOperation = $filePhysicalOperation;
    }


    public function createOrReplace(CategoryFileImageDTO $categoryFileImageDTO): File
    {
        $dir = $this->categoryDirectoryImagePathProvider->getImageDirectoryPath($categoryFileImageDTO->getCategoryId());

        $fileName = $categoryFileImageDTO->getFileName();

        return $this->filePhysicalOperation->createOrReplaceFile($categoryFileImageDTO->getUploadedFile(), $fileName, $dir);
    }

}