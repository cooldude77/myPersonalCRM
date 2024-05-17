<?php

namespace App\Service\Module\WebShop\External\Cart\Mapper;

use App\Form\Module\WebShop\External\Cart\DTO\CartProductDTO;
use App\Service\Module\WebShop\External\Cart\Object\CartObject;
use Doctrine\Common\Collections\ArrayCollection;

class CartDTOMapper
{


    /**
     * @param array $cartArrayList
     *
     * @return ArrayCollection
     *
     * To be used with array from session objects
     */
    public function mapCartToDto(array $cartArrayList): ArrayCollection
    {
        $dtoArray = new  ArrayCollection();
        /** @var CartObject $cartObject */
        foreach ($cartArrayList as $productId => $cartObject) {

            $dto = new CartProductDTO();
            $dto->productId = $productId;
            $dto->quantity = $cartObject->quantity;
            $dtoArray->add($dto);
        }
        return $dtoArray;
    }

}