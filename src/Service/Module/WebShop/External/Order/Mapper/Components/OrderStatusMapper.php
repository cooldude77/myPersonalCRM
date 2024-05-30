<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Entity\OrderStatus;
use App\Repository\OrderStatusRepository;
use App\Service\Module\WebShop\External\Order\SnapShot\OrderSnapShotCreator;

class OrderStatusMapper
{
    public function __construct(private readonly OrderStatusRepository $orderStatusRepository,
        private readonly OrderSnapShotCreator $orderSnapShotCreator
    ) {
    }

    public function mapAndSetHeader($orderHeader, string $orderStatusType): OrderStatus
    {
        $orderStatus = $this->orderStatusRepository->create($orderHeader);

        $orderStatus->setStatus(
            $this->orderStatusRepository->findOneBy(['type' => $orderStatusType])
        );

        $orderStatus->setSnapShot($this->orderSnapShotCreator->createSnapShot($orderHeader));

        return $orderStatus;

    }

}