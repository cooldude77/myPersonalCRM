<?php

namespace App\Form\Module\WebShop\Admin\Mapper;

use App\Form\Module\WebShop\Admin\DTO\WebShopDTO;
use App\Repository\WebShopRepository;

class WebShopDTOMapper
{
    private WebShopRepository $webShopRepository;

    public function __construct(WebShopRepository $webShopRepository)
    {
        $this->webShopRepository = $webShopRepository;
    }

    public function map(WebShopDTO $webShopDTO): \App\Entity\WebShop
    {
        $webShop = $this->webShopRepository->create();
        $webShop->setName($webShopDTO->name);
        $webShop->setDescription($webShopDTO->description);
        return $webShop;
    }
}