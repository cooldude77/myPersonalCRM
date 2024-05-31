<?php

namespace App\Tests\Fixtures;

use App\Entity\Customer;
use App\Entity\User;
use App\Factory\CustomerFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Proxy;

trait CustomerFixture
{
    private User|Proxy $user;
    private Proxy|Customer $customer;

    public function createCustomer(): void
    {

        $this->user = UserFactory::createOne();
        $this->customer = CustomerFactory::createOne(['user' => $this->user]);

    }
}