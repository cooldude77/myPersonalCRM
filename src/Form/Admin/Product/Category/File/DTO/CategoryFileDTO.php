<?php

namespace App\Form\Admin\Product\Category\File\DTO;

use App\Form\Common\File\DTO\FileFormDTO;

class CategoryFileDTO
{

    public ?FileFormDTO $fileFormDTO = null;

    public  int $categoryId= 0 ;


    public function __construct()
    {
        $this->fileFormDTO = new FileFormDTO();
    }


}