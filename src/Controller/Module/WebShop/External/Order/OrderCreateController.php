<?php

namespace App\Controller\Module\WebShop\External\Order;

use App\Service\Module\WebShop\External\Order\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderCreateController extends AbstractController
{

    /**
     * @param OrderService $orderService
     *
     * @return Response
     *
     *  Create Order from cart
     */
    #[Route('/web-shop/order/create', 'web_shop_create_order_after_checkout')]
    public function create(OrderService $orderService): Response {

        $orderService->mapAndPersist();
        $orderService->flush();

        return $this->redirectToRoute('web_shop_payment');

    }

}