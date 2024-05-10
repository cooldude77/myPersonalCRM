<?php

namespace App\Service\MasterData\Category\File\Image;

use App\Form\MasterData\Category\File\DTO\CategoryImageDTO;
use App\Service\Common\File\FilePhysicalOperation;
use App\Service\MasterData\Category\File\Provider\CategoryDirectoryImagePathProvider;
use Symfony\Component\HttpFoundation\File\File;


class CategoryImageOperation
{

    private CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider;
    private FilePhysicalOperation $filePhysicalOperation;

    public function __construct( FilePhysicalOperation $filePhysicalOperation, CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider)
    {


        $this->categoryDirectoryImagePathProvider = $categoryDirectoryImagePathProvider;
        $this->filePhysicalOperation = $filePhysicalOperation;
    }


    public function createOrReplace(CategoryImageDTO $categoryFileImageDTO): File
    {
        $dir = $this->categoryDirectoryImagePathProvider->getImageDirectoryPath($categoryFileImageDTO->getCategoryId());

        $fileName = $categoryFileImageDTO->getFileName();

        return $this->filePhysicalOperation->createOrReplaceFile($categoryFileImageDTO->getUploadedFile(), $fileName, $dir);
    }

}