<?php

namespace App\Controller\Module\WebShop\External\Payment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckOutPaymentController extends AbstractController
{

    public function performPayment(): \Symfony\Component\HttpFoundation\RedirectResponse
    {

       return $this->redirectToRoute('module_web_shop_order_confirmation');
    }
}