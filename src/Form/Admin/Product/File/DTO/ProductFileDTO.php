<?php

namespace App\Form\Admin\Product\File\DTO;

use App\Form\Common\File\DTO\FileFormDTO;

/**
 * DTO should contain no objects of entity type
 */
class ProductFileDTO
{

    public ?FileFormDTO $fileFormDTO = null;

    public  int $productId= 0 ;


}