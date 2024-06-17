<?php

namespace App\EventSubscriber\Module\WebShop\External\Order;

use App\Event\Module\WebShop\External\Cart\CartClearedByUserEvent;
use App\Event\Module\WebShop\External\Cart\CartEvent;
use App\Event\Module\WebShop\External\Cart\CartEventTypes;
use App\Event\Module\WebShop\External\Cart\CartItemAddedEvent;
use App\Event\Module\WebShop\External\Cart\CartItemDeletedEvent;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionProductService;
use App\Service\Module\WebShop\External\Order\OrderRead;
use App\Service\Module\WebShop\External\Order\OrderSave;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class OrderCartEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private OrderSave $orderSave,
        private readonly OrderRead $orderRead,
        private readonly CartSessionProductService $cartSessionProductService,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CartEventTypes::POST_CART_INITIALIZED => 'postCartInitialized',
            CartEventTypes::ITEM_ADDED_TO_CART => 'newItemAdded',
            CartEventTypes::ITEM_DELETED_FROM_CART => 'itemDeleted',
            CartEventTypes::CART_CLEARED_BY_USER => 'cartCleared',
            CartEventTypes::POST_CART_QUANTITY_UPDATED => 'onCartQuantityUpdated',
        ];

    }

    public function postCartInitialized(CartEvent $event): void
    {
        if ($this->cartSessionProductService->isCartEmpty()) {
                $this->orderSave->createNewOrderFromCart($event->getCustomer());

        }

    }

    public function onCartQuantityUpdated(CartEvent $event): void
    {


        $orderHeader = $this->orderRead->getOpenOrder($event->getCustomer());
        $orderItems = $this->orderRead->getOpenOrderItems($orderHeader);
        $this->orderSave->updateOrderItemsFromCartArray(
            $this->cartSessionProductService->getCartArray(),
            $orderItems
        );
    }

    public function newItemAdded(CartItemAddedEvent $event): void
    {
        // todo : check for open order
        // assuming it exists

        $orderHeader = $this->orderRead->getOpenOrder($event->getCustomer());
        $orderItem = $this->orderRead->createOrderItem(
            $orderHeader, $event->getProduct(),
            $event->getQuantity()
        );

        $this->orderSave->updateOrderAddItem($orderItem);

    }

    public function itemDeleted(CartItemDeletedEvent $event): void
    {

        $orderHeader = $this->orderRead->getOpenOrder($event->getCustomer());
        $orderItems = $this->orderRead->getOpenOrderItems($orderHeader);
        $this->orderSave->updateOrderRemoveItem($event->getProduct(), $orderItems);

    }

    public function cartCleared(CartClearedByUserEvent $event): void
    {
        $orderHeader = $this->orderRead->getOpenOrder($event->getCustomer());
        $orderItems = $this->orderRead->getOpenOrderItems($orderHeader);
        $this->orderSave->removeAllItems($orderItems);

    }

}