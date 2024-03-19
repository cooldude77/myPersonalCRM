<?php

namespace App\Form\Admin\Product\File\DTO;

use App\Form\Common\File\DTO\FileFormDTO;

class ProductFileDTO
{

    public ?FileFormDTO $fileFormDTO = null;

    public  int $productId= 0 ;


    public function __construct()
    {
        $this->fileFormDTO = new FileFormDTO();
    }


}