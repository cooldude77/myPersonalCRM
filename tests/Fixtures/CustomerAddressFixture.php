<?php

namespace App\Tests\Fixtures;

use App\Factory\CustomerAddressFactory;
use App\Factory\CustomerFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Proxy;

trait CustomerAddressFixture
{
     private \Zenstruck\Foundry\Proxy|\App\Entity\CustomerAddress $addressBilling;
    private \Zenstruck\Foundry\Proxy|\App\Entity\CustomerAddress $addressShipping;

    public function createCustomerAddressInSession(Proxy $customer): void
    {

     $this->addressBilling = CustomerAddressFactory::createOne(['customer'=>$customer,
         'addressType'=>'billing']);
     $this->addressShipping = CustomerAddressFactory::createOne(['customer'=>$customer,
         'addressType'=>'shipping']);
 }
}