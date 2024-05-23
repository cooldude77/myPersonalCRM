<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Entity\OrderHeader;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\Order\DTO\OrderObject;

class WebShopOrderService
{

    public function __construct(private readonly CartSessionService $cartService)
    {
    }

    public function createOrderObject(): OrderObject
    {

        $orderObject = new OrderObject();

        $header = new OrderHeader();

        // todo: complete this
        return $orderObject;


    }

}