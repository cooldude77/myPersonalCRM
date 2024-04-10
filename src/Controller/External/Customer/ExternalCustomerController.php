<?php

namespace App\Controller\External\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExternalCustomerController extends AbstractController
{
    #[Route('/customer/registration', name: 'external_customer_registration')]
    public function createProduct(EntityManagerInterface $entityManager, Request $request): Response
    {

        return $this->render('admin/ui/panel/panel_main.html.twig');
    }

}