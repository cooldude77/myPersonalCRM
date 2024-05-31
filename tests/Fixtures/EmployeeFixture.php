<?php

namespace App\Tests\Fixtures;

use App\Entity\Employee;
use App\Entity\User;
use App\Factory\EmployeeFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Proxy;

trait EmployeeFixture
{
    private User|Proxy $user;
    private Proxy|Employee $employee;

    public function createEmployee(): void
    {

        $this->user = UserFactory::createOne();
        $this->employee = EmployeeFactory::createOne(['user' => $this->user]);

    }
}