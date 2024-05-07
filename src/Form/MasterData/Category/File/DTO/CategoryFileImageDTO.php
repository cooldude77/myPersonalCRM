<?php

namespace App\Form\MasterData\Category\File\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * DTO should contain no objects of entity type
 */
class CategoryFileImageDTO
{

    public ?CategoryFileDTO $categoryFileDTO  = null;
    public ?string $imageType = null;

    public int $minWidth = 0;
    public int $minHeight= 0;

    public function __construct()
    {
        $this->categoryFileDTO = new CategoryFileDTO();
    }


    public function getCategoryId():int
    {
        return $this->categoryFileDTO->categoryId;
    }
   public function setCategoryId(int $categoryId):void
    {
         $this->categoryFileDTO->categoryId = $categoryId;
    }

    public function getFileName():string
    {
        return $this->categoryFileDTO->fileFormDTO->name;
    }

    public function getUploadedFile():UploadedFile
    {
        return $this->categoryFileDTO->fileFormDTO->uploadedFile;
    }


}