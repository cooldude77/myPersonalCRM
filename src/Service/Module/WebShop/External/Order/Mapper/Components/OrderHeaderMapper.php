<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Repository\OrderHeaderRepository;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerService;

class OrderHeaderMapper
{
    public function __construct(private readonly OrderHeaderRepository $orderHeaderRepository,
        private readonly CustomerService $customerService,
        private readonly CustomerFromUserFinder $customerFromUserFinder
    ) {
    }

    public function map(): \App\Entity\OrderHeader
    {

        $customer = $this->customerFromUserFinder->getLoggedInCustomer();

        $orderHeader = $this->orderHeaderRepository->create($customer);

        // todo
        $orderHeader->setSnapShot($this->customerService->snapShot($customer));

        $orderHeader->setDateTimeOfOrder(new \DateTime());

        return $orderHeader;


    }
}