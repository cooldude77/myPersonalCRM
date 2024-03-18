<?php

namespace App\Form\Admin\Product\Image\DTO;

use App\Form\Common\File\DTO\FileFormDTO;

class ProductFileDTO
{

    public FileFormDTO $fileFormDTO ;

    public int|null $id=null;

    public function __construct()
    {
        $this->fileFormDTO = new FileFormDTO();
    }

}