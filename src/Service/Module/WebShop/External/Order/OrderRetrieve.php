<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Entity\Customer;
use App\Repository\OrderStatusRepository;

class OrderRetrieve
{

    public function __construct(private  readonly OrderStatusRepository $orderStatusRepository)
    {
    }

    public function isAnyOrderInCreatedState(Customer $customer)
    {

        $this->orderStatusRepository->getOpenOrderStatus($customer);

    }
}