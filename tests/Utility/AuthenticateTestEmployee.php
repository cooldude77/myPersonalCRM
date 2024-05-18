<?php

namespace App\Tests\Utility;

use App\Entity\Employee;
use App\Factory\EmployeeFactory;
use Zenstruck\Foundry\Proxy;

trait AuthenticateTestEmployee
{
    private function authenticateEmployee(\Symfony\Bundle\FrameworkBundle\KernelBrowser $client
    ): Proxy {   // Authenticated entry
        $employee = EmployeeFactory::createOne();

        $client->loginUser($employee->getUser());

        return $employee;
    }

}