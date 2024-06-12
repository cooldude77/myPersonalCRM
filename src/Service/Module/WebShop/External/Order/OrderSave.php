<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Entity\OrderHeader;
use App\Repository\OrderStatusRepository;
use App\Service\Module\WebShop\External\CheckOut\Address\DatabaseOperations;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderAddressMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderHeaderMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderItemMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderStatusMapper;
use App\Service\Module\WebShop\External\Order\SnapShot\OrderSnapShotCreator;
use App\Service\Module\WebShop\External\Order\Status\OrderStatusTypes;

/**
 *
 */
class OrderSave
{

    /**
     * @param OrderHeaderMapper     $orderHeaderMapper
     * @param OrderItemMapper       $orderItemMapper
     * @param OrderAddressMapper    $orderAddressMapper
     * @param OrderStatusMapper     $orderStatusMapper
     * @param OrderSnapShotCreator  $orderSnapShotCreator
     * @param OrderStatusRepository $orderStatusRepository
     * @param DatabaseOperations    $databaseOperations
     */
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


    /**
     * @return void
     */
    public function initializeFromCartAndSave(): void
    {


        $orderHeader = $this->orderHeaderMapper->map();
        $x = OrderStatusTypes::ORDER_CREATED;
        $orderStatus = $this->orderStatusMapper->mapAndSetHeader(
            $orderHeader,
            OrderStatusTypes::ORDER_CREATED,
            "note" //todo
        );


        $this->databaseOperations->persist($orderHeader);
        $this->databaseOperations->persist($orderStatus);

        $this->databaseOperations->flush();

    }

    /**
     * @param OrderHeader $orderHeader
     *
     * @return void
     */
    public function flush(OrderHeader $orderHeader): void
    {
        $this->databaseOperations->flush();

        $snapShot = $this->orderSnapShotCreator->createSnapShot($orderHeader);

        $orderStatus = $this->orderStatusRepository->findOneBy(['orderHeader' => $orderHeader]);

        $orderStatus->setSnapShot($snapShot);

        $this->databaseOperations->persist($orderHeader);
        $this->databaseOperations->flush();

    }

    /**
     * @return OrderHeader
     */
    public function mapAndPersist(): OrderHeader
    {
        $this->orderPreMapAndPersistChecks();

        $orderHeader = $this->orderHeaderMapper->map();

        $orderItems = $this->orderItemMapper->mapAndSetHeader($orderHeader);
        $orderAddresses = $this->orderAddressMapper->mapAndSetHeader($orderHeader);
        $orderStatus = $this->orderStatusMapper->mapAndSetHeader(
            $orderHeader,
            OrderStatusTypes::ORDER_CREATED,
            "note" //todo
        );

        // validate

        $this->databaseOperations->persist($orderHeader);

        foreach ($orderItems as $item) {
            $this->databaseOperations->persist($item);
        }


        $this->databaseOperations->persist($orderAddresses);
        $this->databaseOperations->persist($orderStatus);


        return $orderHeader;

    }

    /**
     * @return void
     */
    private function orderPreMapAndPersistChecks()
    {

        // todo
    }
}