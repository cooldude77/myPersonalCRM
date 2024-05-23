<?php

namespace App\Controller\Module\WebShop\External\Order;

use App\Form\Module\WebShop\External\Order\DTO\OrderObjectDTO;
use App\Service\Module\WebShop\External\CheckOut\Component\OrderAddressDTOCreator;
use App\Service\Module\WebShop\External\CheckOut\Component\OrderHeaderDTOCreator;
use App\Service\Module\WebShop\External\CheckOut\Component\OrderItemDTOCreator;

/**
 * Order object for mapping from cart and other details into OrderObjectDTO
 */
class OrderObjectDTOCreator
{

    public function __construct(
        private readonly OrderHeaderDTOCreator $orderHeaderDTOCreator,
        private readonly OrderItemDTOCreator $orderItemDTOCreator,
        private readonly OrderAddressDTOCreator $orderAddressDTOCreator

    ) {
    }

    public function mapAndCreate(): OrderObjectDTO
    {

        $orderObjectDTO = new OrderObjectDTO();

        $orderObjectDTO->orderHeaderDTO = $this->orderHeaderDTOCreator->create();
        $orderObjectDTO->orderItemDTOArray = $this->orderItemDTOCreator->create();
        //$orderObjectDTO->orderAddressDTOArray = $this->orderAddressDTOCreator->create();

        return $orderObjectDTO;
    }

}