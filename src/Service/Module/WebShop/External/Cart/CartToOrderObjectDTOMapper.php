<?php

namespace App\Service\Module\WebShop\External\Cart;

use App\Entity\Customer;
use App\Form\Module\WebShop\External\Order\DTO\Components\Components\OrderItemDTO;
use App\Form\Module\WebShop\External\Order\DTO\OrderObjectDTO;
use App\Service\Module\WebShop\External\Cart\Session\Object\CartSessionObject;

class CartToOrderObjectDTOMapper
{

    public function __construct(private readonly CartService $cartService,
    ) {
    }

    public function map(Customer $customer): OrderObjectDTO
    {

        $orderObjectDTO = new OrderObjectDTO();

        $orderObjectDTO->orderHeaderDTO->customerId = $customer->getId();
        $orderObjectDTO->orderHeaderDTO->dateTimeOfOrder = date_format(
            new \DateTime(), "Y/m/d H:i:s"
        );;

        /**
         * @var  int              $productId
         * @var CartSessionObject $cartObject
         */
        foreach ($this->cartService->getCartArray() as $productId => $cartObject) {

            $orderItemDTO = new OrderItemDTO();

            $orderItemDTO->productId = $productId;
            $orderItemDTO->quantity = $cartObject->quantity;

            $orderObjectDTO->add($orderItemDTO);

        }

        return $orderObjectDTO;
    }

}