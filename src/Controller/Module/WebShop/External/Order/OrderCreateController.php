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
     *  Create Order after checkout and before payment.
     *  Payment info to be added later
     */
    #[Route('/web-shop/order/create', 'web_shop_create_order')]
    public function create(OrderService $orderService): Response
    {

        $orderHeader = $orderService->mapAndPersist();
        $orderService->flush($orderHeader);

        return $this->redirectToRoute(
            'web_shop_order_complete_details', ['id' => $orderHeader->getId()]
        );

    }

}