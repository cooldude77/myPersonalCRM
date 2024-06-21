<?php

namespace App\Controller\Module\WebShop\External\Order;

use App\Repository\OrderHeaderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderConfirmationController extends AbstractController
{


    #[Route('/order/success', 'module_web_shop_order_complete_details')]
    public function thankYou(OrderHeaderRepository $orderHeaderRepository
    ): Response {
        // todo: check referring route
        // this page will be displayed only when referred from payment

        $orderHeader = $orderHeaderRepository->findOneBy($id);

        return $this->render(
            'module/web_shop/external/order/thank_you_for_your_order.html.twig',
            ['orderHeader' => $orderHeader]
        );

    }
}