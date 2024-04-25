<?php

namespace App\Form\Module\WebShop\Admin\File\DTO;

use App\Form\Common\File\DTO\FileFormDTO;

class WebShopFileDTO
{

    public ?FileFormDTO $fileFormDTO = null;

    public  int $webShopId= 0 ;


    public function __construct()
    {
        $this->fileFormDTO = new FileFormDTO();
    }


}