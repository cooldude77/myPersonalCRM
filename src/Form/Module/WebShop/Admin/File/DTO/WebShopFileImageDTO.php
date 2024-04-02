<?php

namespace App\Form\Module\WebShop\Admin\File\DTO;

use App\Entity\WebShopFile;
use App\Entity\WebShopImageType;

class WebShopFileImageDTO
{

    public ?WebShopFileDTO $webShopFileDTO  = null;
    public ?string $imageType = null;

    public int $minWidth = 0;
    public int $minHeight= 0;

    public function __construct()
    {
        $this->webShopFileDTO = new WebShopFileDTO();
    }

    public function create():WebShopFileImageDTO
    {
        return new WebShopFileImageDTO();
    }


}