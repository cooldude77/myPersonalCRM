<?php

namespace App\Tests\Fixtures;

use App\Service\Module\WebShop\External\CheckOut\Address\CheckOutAddressService;
use App\Tests\Utility\MySessionFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait WebShopAddressFixture
{
    private function setAddressesInSession(KernelBrowser $browser, int $idShippingAddress,
        int $idBillingAddress
    ): void {
        /** @var MySessionFactory $factory */
        $factory = $browser->getContainer()->get('session.factory');

        $session = $factory->createSession();
        $session->set(CheckOutAddressService::SHIPPING_ADDRESS_ID, $idShippingAddress);
        $session->set(CheckOutAddressService::BILLING_ADDRESS_ID, $idBillingAddress);
        $session->save();
    }


}