<?php

namespace App\Service\Module\WebShop\External\Payment;

use App\Service\Module\WebShop\External\Order\WebShopOrderService;

class PaymentService
{
    public function __construct(private readonly WebShopOrderService $orderService)
    {

    }

    public function createNewOrder(): array
    {

        return $this->orderService->createCompleteOrderArray();

    }
}