<?php

namespace App\Tests\Fixtures;

use App\Controller\Module\WebShop\External\Address\CheckOutAddressService;
use App\Entity\CustomerAddress;
use App\Tests\Utility\MySessionFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Zenstruck\Foundry\Proxy;

trait WebShopAddressFixture
{
    private function setAddressesInSession(KernelBrowser $browser,
        Proxy|CustomerAddress $addressShipping, Proxy|CustomerAddress $addressBilling
    ): void {
        /** @var MySessionFactory $factory */
        $factory = $browser->getContainer()->get('session.factory');

        $session = $factory->createSession();
        $session->set(CheckOutAddressService::SHIPPING_ADDRESS_ID, $addressShipping->getId());
        $session->set(CheckOutAddressService::BILLING_ADDRESS_ID, $addressBilling->getId());
        $session->save();
    }


}