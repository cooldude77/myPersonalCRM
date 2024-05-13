<?php

namespace App\Tests\Fixtures;

use App\Factory\EmployeeFactory;
use App\Factory\UserFactory;

trait EmployeeFixture
{
    private \App\Entity\User|\Zenstruck\Foundry\Proxy $user;
    private \Zenstruck\Foundry\Proxy|\App\Entity\Employee $employee;

    public function createEmployee(): void
    {

     $this->user = UserFactory::createOne();
     $this->employee = EmployeeFactory::createOne(['user'=>$this->user]);

 }
}