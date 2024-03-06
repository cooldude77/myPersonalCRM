<?php
// src/Controller/CustomerController.php
namespace App\Controller\Admin\Customer;

// ...
use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }
}