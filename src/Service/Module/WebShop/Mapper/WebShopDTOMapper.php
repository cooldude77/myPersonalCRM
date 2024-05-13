<?php

namespace App\Service\Module\WebShop\Mapper;


use App\Entity\WebShop;
use App\Form\Module\WebShop\Admin\DTO\WebShopDTO;
use App\Repository\WebShopRepository;

class WebShopDTOMapper
{
    public function __construct(private WebShopRepository $webShopRepository)
    {
    }



    public function mapToEntityForCreate(WebShopDTO $webShopDTO): WebShop
    {
        $webShop = $this->webShopRepository->create();
        $webShop->setName($webShopDTO->name);
        $webShop->setDescription($webShopDTO->description);
        return $webShop;
    }

    public function mapToEntityForEdit(WebShopDTO $webShopDTO, WebShop $webShop
    ):WebShop {

        $webShop->setName($webShopDTO->name);
        $webShop->setDescription($webShopDTO->description);
        return $webShop;

    }
}