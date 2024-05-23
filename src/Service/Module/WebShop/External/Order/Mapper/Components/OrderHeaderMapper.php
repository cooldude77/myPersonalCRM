<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

class OrderHeaderMapper
{
    public function
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