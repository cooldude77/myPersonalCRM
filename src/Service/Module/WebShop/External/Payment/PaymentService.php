<?php

namespace App\Service\Module\WebShop\External\Payment;

use App\Service\Module\WebShop\External\Order\DTO\OrderObject;
use App\Service\Module\WebShop\External\Order\WebShopOrderService;

class PaymentService
{
    public function __construct(private readonly WebShopOrderService $webShopOrderService)
    {

    }

    public function createNewOrder(): OrderObject
    {

        return $this->webShopOrderService->createOrderObject();

    }
}