<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Form\Module\WebShop\External\Order\DTO\OrderObjectDTO;

class OrderHeaderDtoEntityMapper
{
    public function map()
    {

        $customer = $this->customerRepository->find($orderObjectDTO->orderHeaderDTO->customerId);

        $orderHeader = $this->orderHeaderRepository->create($customer);
        $orderHeader->setDateTimeOfOrder(
            new
            \DateTime(
                $orderObjectDTO->orderHeaderDTO->dateTimeOfOrder
            )
        );



    }
}