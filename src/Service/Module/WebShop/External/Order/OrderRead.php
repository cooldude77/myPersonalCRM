<?php

namespace App\Service\Module\WebShop\External\Order;

use App\Entity\Customer;
use App\Entity\OrderHeader;
use App\Entity\OrderItem;
use App\Entity\PriceProductBase;
use App\Entity\Product;
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


    public function isOpenOrder(Customer $customer): bool
    {
        $orderStatusType = $this->orderStatusTypeRepository->findOneBy(
            ['type' => OrderStatusTypes::ORDER_CREATED]
        );

        return $this->orderHeaderRepository->findOneBy(['customer' => $customer,
                                                        'orderStatusType' => $orderStatusType])
            != null;
    }

    public function createOrderItem(?OrderHeader $orderHeader,
        Product $product, int $quantity
    ): OrderItem {

        /** @var PriceProductBase $price */
        $price = $this->priceProductBaseRepository->findOneBy(['product' => $product]);

        return $this->orderItemRepository->create(
            $orderHeader, $product, $quantity, $price->getPrice()
        );

    }

    public function getOpenOrderItems(OrderHeader $orderHeader): array
    {

        return $this->orderItemRepository->findBy(['orderHeader' => $orderHeader]);

    }

    public function getOpenOrder(Customer $customer): ?OrderHeader
    {
        $orderStatusType = $this->orderStatusTypeRepository->findOneBy(
            ['type' => OrderStatusTypes::ORDER_CREATED]
        );

        return $this->orderHeaderRepository->findOneBy(['customer' => $customer,
                                                        'orderStatusType' => $orderStatusType]);
    }

}