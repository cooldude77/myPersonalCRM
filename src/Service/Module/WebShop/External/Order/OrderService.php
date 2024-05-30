<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Entity\OrderHeader;
use App\Repository\OrderStatusRepository;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\CheckOut\Address\DatabaseOperations;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderAddressMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderHeaderMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderItemMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderStatusMapper;
use App\Service\Module\WebShop\External\Order\SnapShot\OrderSnapShotCreator;
use App\Service\Module\WebShop\External\Order\Status\OrderStatusTypes;

class OrderService
{

    public function __construct(
        private readonly OrderHeaderMapper $orderHeaderMapper,
        private readonly OrderItemMapper $orderItemMapper,
        private readonly OrderAddressMapper $orderAddressMapper,
        private readonly OrderStatusMapper $orderStatusMapper,
        private readonly OrderSnapShotCreator $orderSnapShotCreator,
        private readonly OrderStatusRepository $orderStatusRepository,
        private readonly DatabaseOperations $databaseOperations
    ) {
    }

    public function mapAndPersist(): OrderHeader
    {
        $this->orderPreMapAndPersistChecks();

        $orderHeader = $this->orderHeaderMapper->map();

        $this->orderItemMapper->mapAndSetHeader($orderHeader);
        $this->orderAddressMapper->mapAndSetHeader($orderHeader);
        $this->orderStatusMapper->mapAndSetHeader($orderHeader, OrderStatusTypes::ORDER_CREATED);

        $this->databaseOperations->persist($orderHeader);

        return $orderHeader;

    }

    public function flush(OrderHeader $orderHeader): void
    {
        $this->databaseOperations->flush();

        $snapShot = $this->orderSnapShotCreator->createSnapShot($orderHeader);

        $orderStatus = $this->orderStatusRepository->findOneBy(['orderHeader' => $orderHeader]);

        $orderStatus->setSnapShot($snapShot);

        $this->databaseOperations->persist($orderHeader);
        $this->databaseOperations->flush();

    }

    private function orderPreMapAndPersistChecks()
    {

        // todo
    }
}