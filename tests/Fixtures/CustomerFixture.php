<?php

namespace App\Tests\Fixtures;

use App\Factory\CustomerFactory;
use App\Factory\UserFactory;

trait CustomerFixture
{
    private \App\Entity\User|\Zenstruck\Foundry\Proxy $user;
    private \Zenstruck\Foundry\Proxy|\App\Entity\Customer $customer;

    public function createCustomer(): void
    {

     $this->user = UserFactory::createOne();
     $this->customer = CustomerFactory::createOne(['user'=>$this->user]);

 }
}