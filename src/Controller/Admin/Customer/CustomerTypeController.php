<?php
// src/Controller/CustomerController.php
namespace App\Controller\Admin\Customer;

// ...
use App\Entity\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerTypeController extends AbstractController
{
    #[Route('/customer/type/create', name: 'create_customer_type')]
    public function createCustomer(EntityManagerInterface $entityManager): Response
    {
        $customer = new CustomerType();

        return new Response('Saved new customer with id ' . $customer->getId());
    }


}