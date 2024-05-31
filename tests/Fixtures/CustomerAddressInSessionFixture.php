<?php

namespace App\Tests\Fixtures;

use App\Entity\CustomerAddress;
use App\Service\Module\WebShop\External\CheckOut\Address\CheckOutAddressService;
use Symfony\Component\HttpFoundation\Session\Session;
use Zenstruck\Foundry\Proxy;

trait CustomerAddressInSessionFixture
{
    private Proxy|CustomerAddress $addressBilling;
    private Proxy|CustomerAddress $addressShipping;

    public function createCustomerAddressInSession(Session $session,
        Proxy|CustomerAddress $addressShipping, Proxy|CustomerAddress $addressBilling
    ):
    void {

        $session->set(CheckOutAddressService::BILLING_ADDRESS_ID, $addressBilling->getId());
        $session->set(CheckOutAddressService::SHIPPING_ADDRESS_ID, $addressShipping->getId());

    }
}