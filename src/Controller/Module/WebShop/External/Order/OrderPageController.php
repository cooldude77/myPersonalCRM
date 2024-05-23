<?php

namespace App\Controller\Module\WebShop\External\Order;

use App\Form\Module\WebShop\External\Order\DTO\OrderObjectDTO;
use App\Repository\OrderRepository;
use App\Service\Module\WebShop\External\Cart\Order\Mapper\CartToOrderObjectDTOMapper;
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
    #[Route('/web-shop/order/create', 'web_shop_create_order')]
    public function create($id,
        OrderObjectDTOCreator $orderObjectDTOCreator,
        CartToOrderObjectDTOMapper $cartToOrderObjectDTOMapper,
        OrderHeaderMapper $orderHeaderMapper,
        OrderItemMapper $orderItemMapper,
        OrderAddressMapper $orderAddressMapper,
        OrderPaymentMapper $orderPaymentMapper
    ): Response {
        // todo: check referring route
        // this page will be displayed only when referred from payment

        // create order object DTO to validate
        $orderObjectDTO = $orderObjectDTOCreator->create();

        //todo: validate DTO

        // convert DTO to entity

        $orderHeader = $orderHeaderMapper->crea()



    }


    #[
        Route('/web-shop/order/{$id}/success', 'web_shop_order_complete_details')]
    public function orderSuccessful($id, OrderRepository $orderRepository): Response
    {
        // todo: check referring route
        // this page will be displayed only when referred from payment


        return $this->render(
            'module/web_shop/external/order/thank_you_for_your_order.html.twig',
            ['order' => $orderRepository->find($id)]
        );

    }
}