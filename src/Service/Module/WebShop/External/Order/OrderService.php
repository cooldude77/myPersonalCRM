<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Service\Module\WebShop\External\CheckOut\Address\DatabaseOperations;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderAddressMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderHeaderMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderItemMapper;

class OrderService
{

    public function __construct(
        private readonly OrderHeaderMapper $orderHeaderMapper,
        private readonly OrderItemMapper $orderItemMapper,
        private readonly OrderAddressMapper $orderAddressMapper,
        private readonly DatabaseOperations $databaseOperations
    ) {
    }

    public function mapAndPersist(): void
    {
        $orderHeader = $this->orderHeaderMapper->map();

        $this->orderItemMapper->map($orderHeader);
        $this->orderAddressMapper->map($orderHeader);

        $this->databaseOperations->persist($orderHeader);


    }

    public function flush(): void
    {
        $this->databaseOperations->flush();
    }
}