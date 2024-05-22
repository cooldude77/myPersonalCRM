<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Entity\OrderHeader;
use App\Service\Module\WebShop\External\Cart\CartService;

class WebShopOrderService
{

    public function __construct(private  readonly CartService $cartService)
    {
    }

    public function createOrderObject  ()
    {

        $order = new OrderHeader();


    }

}