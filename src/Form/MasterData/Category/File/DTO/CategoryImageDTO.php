<?php

namespace App\Form\MasterData\Category\File\DTO;

use App\Entity\File;
use App\Form\Common\File\DTO\FileFormDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * DTO should contain no objects of entity type
 */
class CategoryImageDTO
{

    public ?FileFormDTO $fileFormDTO  = null;

    public int $categoryId = 0;

    public int $minWidth = 0;
    public int $minHeight= 0;

    public function __construct()
    {
        $this->fileFormDTO = new FileFormDTO();
    }


    public function getCategoryId():int
    {
        return $this->categoryId;
    }
   public function setCategoryId(int $categoryId):void
    {
         $this->categoryId = $categoryId;
    }

    public function getFileName():string
    {
        return $this->fileFormDTO->name;
    }

    public function getUploadedFile():UploadedFile
    {
        return $this->fileFormDTO->uploadedFile;
    }


}