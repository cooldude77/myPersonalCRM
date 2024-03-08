<?php
// src/Controller/CustomerController.php
namespace App\Controller\Admin\Customer;

// ...
use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{

    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }
}