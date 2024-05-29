<?php

namespace App\Controller\Module\WebShop\External\Order;

use App\Service\Module\WebShop\External\Order\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderPageController extends AbstractController
{




    #[Route('/order/{$id}/success', 'web_shop_order_complete_details')] public function orderSuccessful($id
    ): Response {
        // todo: check referring route
        // this page will be displayed only when referred from payment


        return $this->render(
            'module/web_shop/external/order/thank_you_for_your_order.html.twig'
        );

    }
}