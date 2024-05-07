<?php

namespace App\Service\MasterData\Product\Category\File\Image;

use App\Form\MasterData\Category\File\DTO\CategoryFileImageDTO;
use App\Service\Common\File\FilePhysicalOperation;
use App\Service\MasterData\Product\Category\File\Provider\CategoryDirectoryImagePathProvider;
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