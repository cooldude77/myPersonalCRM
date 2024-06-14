<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Repository\OrderHeaderRepository;
use App\Repository\OrderStatusTypeRepository;
use App\Service\Module\WebShop\External\Order\Status\OrderStatusTypes;

readonly class OrderRead
{
    public function __construct(private readonly OrderHeaderRepository $orderHeaderRepository,
        private readonly OrderStatusTypeRepository $orderStatusTypeRepository
    ) {
    }


    public function isOpenOrder(): bool
    {
        $orderStatusType = $this->orderStatusTypeRepository->findOneBy
        (
            ['type' => OrderStatusTypes::ORDER_CREATED]
        );

        return $this->orderHeaderRepository->findOneBy(['orderStatusType' => $orderStatusType])
            != null;
    }

}