<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Controller\Module\WebShop\External\Order\OrderSnapShotCreator;
use App\Entity\OrderStatus;
use App\Repository\OrderStatusRepository;
use App\Repository\OrderStatusTypeRepository;

class OrderStatusMapper
{
    public function __construct(private readonly OrderStatusRepository $orderStatusRepository,
        private readonly OrderSnapShotCreator $orderSnapShotCreator,
        private readonly OrderStatusTypeRepository $orderStatusTypeRepository
    ) {
    }

    public function map($orderHeader, string $orderStatusType, string $orderNote): OrderStatus
    {
        $orderStatusType = $this->orderStatusRepository->create($orderHeader);

        $orderStatusType->setStatus(
            $this->orderStatusRepository->findOneBy(['type' => $orderStatusType])
        );

        $orderStatusType->setNote($orderNote);

        return $orderStatusType;

    }

}