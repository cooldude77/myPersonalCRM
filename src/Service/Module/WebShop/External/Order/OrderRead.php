<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Entity\OrderItem;
use App\Entity\PriceProductBase;
use App\Repository\OrderHeaderRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderStatusTypeRepository;
use App\Repository\PriceProductBaseRepository;
use App\Service\Module\WebShop\External\Order\Status\OrderStatusTypes;

readonly class OrderRead
{
    public function __construct(private readonly OrderHeaderRepository $orderHeaderRepository,
        private readonly OrderItemRepository $orderItemRepository,
        private readonly OrderStatusTypeRepository $orderStatusTypeRepository,
        private readonly PriceProductBaseRepository $priceProductBaseRepository
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

    public function getOpenOrder(): ?\App\Entity\OrderHeader
    {
        $orderStatusType = $this->orderStatusTypeRepository->findOneBy
        (
            ['type' => OrderStatusTypes::ORDER_CREATED]
        );

        return $this->orderHeaderRepository->findOneBy(['orderStatusType' => $orderStatusType]);
    }

    public function createOrderItem(?\App\Entity\OrderHeader $orderHeader,
        \App\Entity\Product $product, int $quantity
    ): OrderItem {

        /** @var PriceProductBase $price */
        $price = $this->priceProductBaseRepository->findOneBy(['product' => $product]);

        return $this->orderItemRepository->create(
            $orderHeader, $product, $quantity,
            $price->getPrice()
        );

    }

    public function getOpenOrderItems(): array
    {

        $order = $this->getOpenOrder();

        return $this->orderItemRepository->findBy(['orderHeader'=>$order]);

    }

}