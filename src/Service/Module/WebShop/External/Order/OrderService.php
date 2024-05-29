<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Controller\Module\WebShop\External\Order\OrderSnapShotCreator;
use App\Entity\OrderHeader;
use App\Service\Module\WebShop\External\CheckOut\Address\DatabaseOperations;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderAddressMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderHeaderMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderItemMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderStatusMapper;

class OrderService
{

    public function __construct(
        private readonly OrderHeaderMapper $orderHeaderMapper,
        private readonly OrderItemMapper $orderItemMapper,
        private readonly OrderAddressMapper $orderAddressMapper,
        private readonly OrderStatusMapper $orderStatusMapper,
        private readonly OrderSnapShotCreator $orderSnapShotCreator,
        private readonly DatabaseOperations $databaseOperations
    ) {
    }

    public function mapAndPersist(): OrderHeader
    {
        $orderHeader = $this->orderHeaderMapper->map();

        $this->orderItemMapper->map($orderHeader);
        $this->orderAddressMapper->map($orderHeader);

        $orderStatus = $this->orderStatusMapper->map($orderHeader, $orderStatus, $note);

        $snapShot = $this->orderSnapShotCreator->createSnapShot($orderHeader);

        $orderStatus->setSnapShot($snapShot);

        $this->databaseOperations->persist($orderHeader);

        return $orderHeader;

    }

    public function flush(): void
    {
        $this->databaseOperations->flush();


    }
}