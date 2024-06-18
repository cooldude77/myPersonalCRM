<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Entity\OrderAddress;
use App\Entity\OrderHeader;
use App\Repository\OrderAddressRepository;
use App\Service\Module\WebShop\External\Address\CheckOutAddressService;

readonly class OrderAddressMapper
{
    public function __construct(private CheckOutAddressService $checkOutAddressService,
        private OrderAddressRepository $orderAddressRepository
    ) {
    }

    public function mapAndSetHeader(OrderHeader $orderHeader): OrderAddress
    {

        $orderAddress = $this->orderAddressRepository->create($orderHeader);

        $orderAddress->setBillingAddress( $this->checkOutAddressService->getBillingAddress());
        $orderAddress->setShippingAddress($this->checkOutAddressService->getShippingAddress());

        return $orderAddress;


    }
}