<?php

namespace App\Controller\Module\WebShop\External\Order;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class OrderPageController extends AbstractController
{
    #[Route('/web-shop/order/{$id}/success', 'web_shop_order_complete_details')]
    public function orderSuccessful($id, OrderRepository $orderRepository)
    {
        // todo: check referring route
        // this page will be displayed only when referred from payment


        return $this->render(
            'module/web_shop/external/order/thank_you_for_order.html.twig',
            ['order' => $orderRepository->find($id)]
        );

    }
}