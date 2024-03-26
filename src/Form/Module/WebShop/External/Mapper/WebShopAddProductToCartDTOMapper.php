<?php

namespace App\Form\Module\WebShop\External\Mapper;

use App\Entity\Product;
use App\Form\Module\WebShop\External\DTO\WebShopAddProductDTO;
use App\Repository\WebShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Session\Session;

class WebShopAddProductToCartDTOMapper
{




    public function createDTOArray(Session $session,array $products): ArrayCollection
    {
        $dtoArray = new ArrayCollection();
        /** @var Product $product */
        foreach ($products as $product) {

            $dto = new WebShopAddProductDTO();
            $dto->productId = $product->getId();
            $dto->quantity = $this->getQuantity($session,$product->getId());
            $dtoArray->add($dto);
        }
        return $dtoArray; /*$dtoArray = array();

        foreach ($products as $product) {

            $dto = new WebShopAddProductDTO();
            $dto->productId = $product->getId();
            $dto->quantity = $this->getQuantity($session,$product->getId());
            $dtoArray[] = $dto;
        }*/
        //return $dtoArray;
    }

    private function getQuantity(Session $session,?int $productId): int
    {
        $cart = $session->get('cart');

        return $cart['products'][$productId]['quantity'] ?? 0;

    }
}