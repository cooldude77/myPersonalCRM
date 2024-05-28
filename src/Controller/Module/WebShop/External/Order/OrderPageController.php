<?php

namespace App\Controller\Module\WebShop\External\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderPageController extends AbstractController
{


    /**
     * @param                 $id
     * @param OrderRepository $orderRepository
     *
     * @return Response
     *
     *  Create Order from cart
     */
    #[Route('/order/create', 'web_shop_create_order_after_checkout')]
    public function create($id,
        OrderObjectDTOCreator $orderObjectDTOCreator,

    ): Response {
        // todo: check referring route
        // this page will be displayed only when referred from payment

        // create order object DTO to validate

        //todo: validate DTO

        // convert DTO to entity


        return new Response();

    }


    #[Route('/order/{$id}/success', 'web_shop_order_complete_details')] public function orderSuccessful($id
    ): Response {
        // todo: check referring route
        // this page will be displayed only when referred from payment


        return $this->render(
            'module/web_shop/external/order/thank_you_for_your_order.html.twig'
        );

    }
}