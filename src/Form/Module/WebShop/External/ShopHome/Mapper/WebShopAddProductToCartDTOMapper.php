<?php

namespace App\Form\Module\WebShop\External\ShopHome\Mapper;

use App\Entity\Product;
use App\Form\Module\WebShop\External\ShopHome\DTO\WebShopProductDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\Session;

class WebShopAddProductToCartDTOMapper
{


    /**
     * @param array $products
     * @return ArrayCollection
     * Used with product entity list
     */
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

    /**
     * @param array $productList
     * @return ArrayCollection
     *
     * To be used with array from session objects
     */
 public function createDTOArrayFromArrayList(array $productList): ArrayCollection
    {
        $dtoArray =new  ArrayCollection();
        /** @var Product $product */
        foreach ($productList as $productId=>$quantity) {

            $dto = new WebShopProductDTO();
            $dto->productId = $productId;
            $dto->quantity = $quantity;
            $dtoArray->add($dto);
        }
        return $dtoArray;
    }

}