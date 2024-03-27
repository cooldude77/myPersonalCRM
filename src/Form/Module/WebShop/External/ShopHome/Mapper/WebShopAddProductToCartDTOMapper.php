<?php

namespace App\Form\Module\WebShop\External\ShopHome\Mapper;

use App\Entity\Product;
use App\Form\Module\WebShop\External\ShopHome\DTO\WebShopProductDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\Session;

class WebShopAddProductToCartDTOMapper
{




    public function createDTOArray1(Session $session,array $products): ArrayCollection
    {
        $dtoArray = new ArrayCollection();
        /** @var Product $product */
        foreach ($products as $product) {

            $dto = new WebShopProductDTO();
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
   public function createDTOArray(array $products): ArrayCollection
    {
        $dtoArray = new ArrayCollection();
        /** @var Product $product */
        foreach ($products as $product) {

            $dto = new WebShopProductDTO();
            $dto->productId = $product->getId();
            $dto->quantity = 0;
            $dtoArray->add($dto);
        }
        return $dtoArray;
    }

    private function getQuantity(Session $session,?int $productId): int
    {
        $cart = $session->get('cart');

        return $cart['products'][$productId]['quantity'] ?? 0;

    }
}